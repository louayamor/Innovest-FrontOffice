<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/investors', name: 'investorslist')]
    public function getInvestor(UserRepository $userRepository): Response
    {
        // Fetch the list of investors
        $investors = $userRepository->findBy(['isInvestor' => true]);

        return $this->render('user/investorslist.html.twig', [
            'investors' => $investors,
        ]);
    }
}
