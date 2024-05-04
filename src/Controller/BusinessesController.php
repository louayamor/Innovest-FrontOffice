<?php

namespace App\Controller;

use App\Entity\Sector;
use App\Entity\Business;
use App\Form\BusinessType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BusinessesController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/businesses', name: 'app_businesses')]
    public function index(): Response
    {
        $businesses = $this->entityManager->getRepository(Business::class)->findAll();

        return $this->render('businesses/index.html.twig', [
            'controller_name' => 'BusinessesController',
            'businesses' => $businesses,
        ]);
    }

    #[Route('/businesses/my_businesses', name: 'app_my_businesses')]
    public function myBusinesses(): Response
    {
        $user = $this->getUser();
        $businesses = $this->entityManager->getRepository(Business::class)->findBy(['Owner' => $user]);

        return $this->render('businesses/my_businesses.html.twig', [
            'controller_name' => 'BusinessesController',
            'businesses' => $businesses,
        ]);
    }

    #[Route('/business/add', name: 'app_add_business')]
    public function addBusiness(Request $request): Response
    {
        $user = $this->getUser();
        $business = new Business();

        $sectors = $this->entityManager->getRepository(Sector::class)->findAll();
        $sectorChoices = [];
        foreach ($sectors as $sector1) {
            $sectorChoices[$sector1->getSectorName()] = $sector1->getSectorName();
        }

        $form = $this->createForm(BusinessType::class, $business, [
            'sector_choices' => $sectorChoices, 
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $business->setSector($form->get('Sector')->getData());


            $business->setOwner($user);
            $this->entityManager->persist($business);
            $this->entityManager->flush();

            
            return $this->redirectToRoute('app_my_businesses');
        }

        return $this->render('businesses/add.html.twig', [
            'form' => $form->createView(),
            'sectors' => $sectors,
        ]);
    }

    #[Route('/business/{id}', name: 'app_business_details', methods: ['GET'])]
    public function businessDetails(Request $request,$id): Response
    {
        $request->getSession()->set('current_business_id', $id);
        $business = $this->entityManager->getRepository(Business::class)->find($id);

        return $this->render('businesses/detail.html.twig', [
            'business' => $business,
        ]);
    }

    #[Route('/business/delete/{id}', name: 'app_delete_business')]
    public function deleteBusiness(Business $business): RedirectResponse
    {
        $this->entityManager->remove($business);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_my_businesses');
    }

    #[Route('/businesses/latest', name: 'app_latest_businesses')]
    public function latestBusinesses(): Response
    {
        $latestBusinesses = $this->entityManager->getRepository(Business::class)
            ->findBy([], ['created_at' => 'DESC'], 3); // Fetch the latest 3 businesses

        return $this->render('businesses/latest_businesses.html.twig', [
            'latestBusinesses' => $latestBusinesses,
        ]);
    }

}
