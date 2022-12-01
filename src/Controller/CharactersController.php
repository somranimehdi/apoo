<?php

namespace App\Controller;
use App\Entity\Characters;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class CharactersController extends AbstractController
{
    #[Route('/characters', name: 'app_characters')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Characters::class);

        $characters = $repository->findAll();
        
        return $this->render('characters/index.html.twig', [
            'characters' =>  $characters,
            'controller_name' => 'CharactersController',
            
        ]);
    }
}
