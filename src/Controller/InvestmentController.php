<?php

namespace App\Controller;

use App\Form\InvestmentType;
use App\Entity\Investment;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Business;

class InvestmentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/investment', name: 'app_investment')]
    public function index(): Response
    {
        return $this->render('investment/index.html.twig', [
            'controller_name' => 'InvestmentController',
        ]);
    }

    #[Route('/investment/add/{Id}', name: 'add_investment')]
    public function addInvestment(Request $request, $Id): Response
    {
        $business = $this->entityManager->getRepository(Business::class)->find($Id);

        if (!$business) {
            throw $this->createNotFoundException('Business not found');
        }

        $investment = new Investment();
        $investment->setBusiness($business);

        $user = $this->getUser();
        $investment->setInvestor($user);

        $form = $this->createForm(InvestmentType::class, $investment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->persist($investment);
            $entityManager->flush();

            if ($user instanceof User) {
                $user->setIsInvestor(true);
                $entityManager->persist($user);
                $entityManager->flush();
            }

            $this->addFlash('success', 'Investment successful!');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('investment/add.html.twig', [
            'form' => $form->createView(),
            'business' => $business,
        ]);
    }
}
