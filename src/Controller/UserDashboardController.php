<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    #[Route('/dashboard', name: 'dashboard')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager= $doctrine->getManager();
        $username=strval($this->getUser());
        $User = $entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        return $this->render('user_dashboard/index.html.twig', [
            'User' => $User,
        ]);
    }
}

