<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $genres = $entityManager->getRepository(Genre::class)->findAll();
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'genres' => $genres,
        ]);
    }
}
