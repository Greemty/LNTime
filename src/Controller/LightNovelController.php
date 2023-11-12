<?php

namespace App\Controller;

use App\Entity\LightNovel;
use App\Form\LightNovelType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lightnovel')]
class LightNovelController extends AbstractController
{
    #[Route('/new', name: 'lightnovel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lightnovel = new LightNovel();
        $form = $this->createForm(LightNovelType::class, $lightnovel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lightnovel);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('light_novel/new.html.twig', [
            'lightnovel' => $lightnovel,
            'form' => $form,
        ]);
    }

    #[Route('/{title}', name: 'lightnovel')]
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
