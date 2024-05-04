<?php

namespace App\Controller;

use App\Entity\Sector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class IncludesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/includes', name: 'app_includes')]
    public function index(): Response
    {
        $query = $this->entityManager->createQuery(
            'SELECT s.SectorName FROM App\Entity\Sector s'
        );
        $sectorNames = $query->getResult();

        return $this->render('includes/header.html.twig', [
            'sectors' => $sectorNames, 
        ]);
    }
}
