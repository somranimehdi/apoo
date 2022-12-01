<?php

namespace App\Controller;

use App\Repository\SuggestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Suggestions;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{    
    private $em;
    private $SuggestionsRepository;
    public function __construct(EntityManagerInterface $em, SuggestionsRepository $SuggestionsRepository)
    {
        $this->em = $em;
        $this->SuggestionsRepository = $SuggestionsRepository;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(ManagerRegistry $doctrine): Response
    {

       
        $user = $this->getUser();
       
        $repository = $doctrine->getRepository(Suggestions::class);

        $Suggestions = $repository->findAll();
        return $this->render('admin/index.html.twig', [
            'user' =>  $user,
            'Suggestions' => $Suggestions
        ]);
    }
}
