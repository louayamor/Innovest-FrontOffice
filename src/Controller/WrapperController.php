<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WrapperController extends AbstractController
{
    #[Route('/', name: 'wrapper')]
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home'); 
        } else {
            return $this->redirectToRoute('app_login'); 
        }
    }
}
