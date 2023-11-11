<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{

    #[Route('/genre/{categoryName}', name: 'genre')]
    public function show(ManagerRegistry $doctrine, string $categoryName): Response
    {
        $genreRepo = $doctrine->getRepository(Genre::class);
        $genre = $genreRepo->findOneBy(['categoryName' => $categoryName]);

        if (!$genre) {
            throw $this->createNotFoundException('The genre does not exist');
        }

        $entityManager= $doctrine->getManager();
        $Genre = $entityManager->getRepository(Genre::class)->findOneBy(['categoryName' => $categoryName]);

        return $this->render('genre/index.html.twig', [
            'genre' => $Genre,
        ]);
    }
}
