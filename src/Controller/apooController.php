<?php

namespace App\Controller;
use App\Entity\Characters;
use App\Entity\Stories;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class apooController extends AbstractController
{
    #[Route('/apoo', name: 'apoo')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Characters::class);

        $characters = $repository->findAll(4);
        $repository = $doctrine->getRepository(Stories::class);

        $stories = $repository->findAll(4);

        return $this->render('home/index.html.twig', [
            'stories' =>  $stories,
            'characters' =>  $characters,
            'controller_name' => 'apooController',
        ]);
    }
}
