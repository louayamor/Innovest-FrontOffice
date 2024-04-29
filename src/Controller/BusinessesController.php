<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BusinessesController extends AbstractController
{
    #[Route('/businesses', name: 'app_businesses')]
    public function index(): Response
    {
        return $this->render('businesses/index.html.twig', [
            'controller_name' => 'BusinessesController',
        ]);
    }
}
