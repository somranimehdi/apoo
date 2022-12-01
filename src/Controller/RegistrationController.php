<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function createuser(Request $request, UserPasswordHasherInterface $userPasswordHasher,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        

        $user = new user();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain passwor
            $user->setEmail($form->get('email')->getData());
            $user->setUsername($form->get('username')->getData());
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
    
            $entityManager->persist($user);
            $entityManager->flush();
            
        
            return $this->redirectToRoute('app_login');
        }
        // tell Doctrine you want to (eventually) save the user (no queries yet)
     
        // actually executes the queries (i.e. the INSERT query)
       

        return $this->render('register/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}



