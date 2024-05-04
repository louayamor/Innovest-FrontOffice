<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Form\ConversationType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class ConversationController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/conversation', name: 'app_conversation')]
    public function index(): Response
    {
        return $this->render('conversation/index.html.twig', [
            'controller_name' => 'ConversationController',
        ]);
    }

    #[Route('/conversation/send/{OwnerId}', name: 'app_conversation_send')]
    public function sendMessage(Request $request, $OwnerId): Response
    {
        $conversation = new Conversation();
        $form = $this->createForm(ConversationType::class, $conversation);

        $receiver = $this->entityManager->getRepository(User::class)->find($OwnerId);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $request->request->get('message');
            $senderId = $this->getUser();

            $conversation = new Conversation();
            $conversation->setMessage($message);
            $conversation->setSender($senderId);
            $conversation->setReciever($receiver);

            $entityManager = $this->entityManager;
            $entityManager->persist($conversation);
            $entityManager->flush();
        }

        return $this->render('conversation/send.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

