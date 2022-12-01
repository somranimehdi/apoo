<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;


use App\Entity\Suggestions;
use App\Form\SuggestionsFormType;
use App\Repository\SuggestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SuggestionsController extends AbstractController
{
   
    private $em;
    private $SuggestionsRepository;
    public function __construct(EntityManagerInterface $em, SuggestionsRepository $SuggestionsRepository)
    {
        $this->em = $em;
        $this->SuggestionsRepository = $SuggestionsRepository;
    }

    #[Route('/Suggestions', name: 'Suggestions')]
    public function index(ManagerRegistry $doctrine): Response
    {

       
        $user = $this->getUser();
       
        $repository = $doctrine->getRepository(Suggestions::class);

        $Suggestions = $repository->findBy(['user_id' => $user]);
        return $this->render('Suggestions/index.html.twig', [
            'user' =>  $user,
            'Suggestions' => $Suggestions
        ]);
    }

    #[Route('/Suggestions/create', name: 'create_Suggestions')]
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $Suggestions = new Suggestions();
        $form = $this->createForm(SuggestionsFormType::class, $Suggestions);

        $form->handleRequest($request);
        $Suggestions = array();
        if ($form->isSubmitted() && $form->isValid()) {
            $newSuggestions = $form->getData();


            $newSuggestions->setUserId($this->getUser());

            $this->em->persist($newSuggestions);
            $this->em->flush();

            return $this->redirectToRoute('Suggestions');
        }

        return $this->render('Suggestions/create.html.twig', [
            'user' =>  $user,
            'Suggestions' => $Suggestions,
            'form' => $form->createView()
        ]);
    }

    #[Route('/Suggestions/edit/{id}', name: 'edit_Suggestions')]
    public function edit($id, Request $request): Response 
    {
        $user = $this->getUser();

        
        
        $Suggestions = $this->SuggestionsRepository->find($id);

        $form = $this->createForm(SuggestionsFormType::class, $Suggestions);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Suggestions->setSugg($form->get('sugg')->getData());

            $this->em->flush();
            return $this->redirectToRoute('Suggestions');
        }

        return $this->render('Suggestions/edit.html.twig', [
            'user' =>  $user,
            'Suggestions' => $Suggestions,
            'form' => $form->createView()
        ]);
    }
    #[Route('/Suggestions/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_Suggestions')]
    public function delete($id): Response
    {
   
        $Suggestions = $this->SuggestionsRepository->find($id);
        $this->em->remove($Suggestions);
        $this->em->flush();

        return $this->redirectToRoute('Suggestions');
    }
}
