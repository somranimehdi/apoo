<?php

namespace App\Controller;


use App\Form\StoryType;
use App\Repository\SuggestionsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Suggestions;
use App\Entity\Stories;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\StoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    private $em;
    private $SuggestionsRepository;
    private $StoriesRepository;
    private $UserRepository;
    public function __construct(EntityManagerInterface $em, SuggestionsRepository $SuggestionsRepository, StoriesRepository  $StoriesRepository,UserRepository $UserRepository)
    {
        $this->em = $em;
        $this->SuggestionsRepository = $SuggestionsRepository;
        $this->StoriesRepository = $StoriesRepository;
        $this->UserRepository = $UserRepository;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(ManagerRegistry $doctrine): Response
    {


        $repository = $doctrine->getRepository(User::class);
        $users = $repository->findAll();
        return $this->render('admin/Users.html.twig', [
            'users' =>  $users

        ]);
    }

    #[Route('/admin/stories', name: 'app_admin_stories')]


    public function stories(ManagerRegistry $doctrine): Response
    {


        $user = $this->getUser();

        $repository = $doctrine->getRepository(Stories::class);
        $stories = $repository->findAll();
        return $this->render('admin/stories.html.twig', [
            'user' =>  $user,
            'stories' => $stories
        ]);
    }
    #[Route('/admin/suggestions', name: 'app_admin_suggestions')]


    public function suggestions(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();



        $repository = $doctrine->getRepository(Suggestions::class);

        $Suggestions = $repository->findAll();
        return $this->render('admin/suggestions.html.twig', [
            'user' =>  $user,
            'Suggestions' => $Suggestions
        ]);
    }


    #[Route('/admin/suggestions/delete/{id}', methods: ['GET', 'DELETE'], name: 'admin_delete_Suggestions')]
    public function delete($id): Response
    {

        $Suggestions = $this->SuggestionsRepository->find($id);
        $this->em->remove($Suggestions);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_suggestions');
    }


    #[Route('/admin/stories/create', name: 'app_admin_create_stories')]
    public function create_story(Request $request): Response
    {

        $user = $this->getUser();
        $Stories = new Stories();
        $form = $this->createForm(StoryType::class, $Stories);

        $form->handleRequest($request);
        $Stories = array();
        if ($form->isSubmitted() && $form->isValid()) {
            $newStories = $form->getData();
            $this->em->persist($newStories);
            $this->em->flush();
            return $this->redirectToRoute('app_admin_stories');
        }
        $form->handleRequest($request);
        $Stories = array();

        return $this->render('admin/CreateStory.html.twig', [
            'user' =>  $user,
            'form' => $form->createView(),
            'stories' => $Stories
        ]);
    }

    #[Route('/admin/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_User')]
    public function deleteUser($id): Response
    {
   
        $User = $this->UserRepository->find($id);

        $this->em->remove($User);
        $this->em->flush();

        return $this->redirectToRoute('app_admin');
    }

    
    #[Route('/admin/delete/story/{id}', methods: ['GET', 'DELETE'], name: 'delete_Story')]
    public function deleteStory($id): Response
    {
   
        $Story = $this->StoriesRepository->find($id);

        $this->em->remove($Story);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_stories');
    }
}
