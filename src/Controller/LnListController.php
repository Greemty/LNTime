<?php

namespace App\Controller;

use App\Entity\LnList;
use App\Form\LnListType;
use App\Repository\LnListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lnlist')]
class LnListController extends AbstractController
{
    #[Route('/', name: 'app_ln_list_index', methods: ['GET'])]
    public function index(LnListRepository $lnListRepository): Response
    {
        return $this->render('ln_list/index.html.twig', [
            'ln_lists' => $lnListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ln_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lnList = new LnList();
        $form = $this->createForm(LnListType::class, $lnList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lnList);
            $entityManager->flush();

            return $this->redirectToRoute('app_ln_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ln_list/new.html.twig', [
            'ln_list' => $lnList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ln_list_show', methods: ['GET'])]
    public function show(LnList $lnList): Response
    {
        return $this->render('ln_list/show.html.twig', [
            'ln_list' => $lnList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ln_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LnList $lnList, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LnListType::class, $lnList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ln_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ln_list/edit.html.twig', [
            'ln_list' => $lnList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ln_list_delete', methods: ['POST'])]
    public function delete(Request $request, LnList $lnList, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lnList->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lnList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ln_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
