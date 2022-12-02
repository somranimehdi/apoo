<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Stories;
use App\Repository\StoriesRepository;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Completion\Suggestion;

class SavedStoriesController extends AbstractController
{

    private $em;
    private $StoriesRepository;
    private $UserRepository;

    public function __construct(EntityManagerInterface $em,UserRepository $UserRepository, StoriesRepository $StoriesRepository)
    {
        $this->em = $em;
        $this->StoriesRepository = $StoriesRepository;
        $this->UserRepository = $UserRepository;
    }

    #[Route('/saved/{id}', name: 'app_saved_stories')]
    public function index(int $id,ManagerRegistry $doctrine): Response
    {

        $user = $this->UserRepository->find($id);
        $stories = $user->getStories()->getValues();
     
    
        
        return $this->render('saved_stories/index.html.twig', [
            'controller_name' => 'SavedStoriesController',
            'user' =>  $user,
            'stories' => $stories
        ]);
    }



    #[Route('/delete/{id}/{story_id}', name: 'delete_saved_story')]
    public function delete(int $id,int $story_id,ManagerRegistry $doctrine): Response
    {

        $user = $this->UserRepository->find($id);
        $story =  $this->StoriesRepository->find($story_id);
     
        $user->removeStory($story);
        $this->em->flush();
    
        
         return $this->redirectToRoute('app_saved_stories',['id'=>$id]);

    }


}
