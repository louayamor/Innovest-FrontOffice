<?php

namespace App\Controller;

use App\Entity\UserProfile;
use App\Form\UserProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();

        $uProfile = $this->entityManager->getRepository(UserProfile::class)->findOneBy(['user' => $user]);;

        if (!$uProfile) {           
            return $this->redirectToRoute('complete');
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'uProfile' => $uProfile,
        ]);
    }

    #[Route('/complete', name: 'complete')]
    public function completeProfile(Request $request): Response
{
    $userProfile = new UserProfile();
    $form = $this->createForm(UserProfileType::class, $userProfile);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $userProfile->setUser($this->getUser());
        $entityManager = $this->entityManager;
        $entityManager->persist($userProfile);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    return $this->render('profile/complete.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
