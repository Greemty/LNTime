<?php

namespace App\Controller;

use App\Entity\LightNovel;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LightNovelController extends AbstractController
{
    #[Route('/lightnovel/{title}', name: 'lightnovel')]
    public function show(ManagerRegistry $doctrine, string $title): Response
    {
        $genreRepo = $doctrine->getRepository(LightNovel::class);
        $genre = $genreRepo->findOneBy(['title' => $title]);

        if (!$genre) {
            throw $this->createNotFoundException('The lightnovel does not exist');
        }

        $entityManager= $doctrine->getManager();
        $LightNovel = $entityManager->getRepository(LightNovel::class)->findOneBy(['title' => $title]);

        return $this->render('light_novel/index.html.twig', [
            'lightnovel' => $LightNovel,
        ]);
    }
}
