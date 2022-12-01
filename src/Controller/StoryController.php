<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Stories;
use App\Repository\StoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class StoryController extends AbstractController
{

    private $em;
    private $StoriesRepository;
    public function __construct(EntityManagerInterface $em, StoriesRepository $StoriesRepository)
    {
        $this->em = $em;
        $this->StoriesRepository = $StoriesRepository;
    }

    #[Route('/stories', name: 'app_stories')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Stories::class);

        $stories = $repository->findAll();
        
        
        return $this->render('stories/index.html.twig', [
            'stories' =>  $stories,

            'controller_name' => 'StoryController',

        ]);
    }

    
}
