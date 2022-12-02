<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\EditFormType;
use PharIo\Manifest\Email;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ProfileController extends AbstractController
{

    private $em;
    private $UserRepository;
    public function __construct(EntityManagerInterface $em, UserRepository $UserRepository)
    {
        $this->em = $em;
        $this->UserRepository = $UserRepository;
    }

    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {    

        

        return $this->redirectToRoute('Suggestions');

    }
    #[Route('/settings', name: 'settings')]
    public function edit(Request $request): Response 
    {
        $User = $this->getUser();
        $UserEdit =  $this->UserRepository->find($User);
        $form = $this->createForm(EditFormType::class, $User);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $UserEdit->setEmail($form->get('email')->getData());
   
            $this->em->flush();
            return $this->redirectToRoute('Suggestions');
        }

        return $this->render('home/settings.html.twig', [
            'user' =>  $User,

            'EditForm' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_account')]
    public function delete($id): Response
    {
   
        $User = $this->UserRepository->find($id);
        $this->em->remove($User);
        $this->em->flush();

        return $this->redirectToRoute('app_logout');
    }
}

