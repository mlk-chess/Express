<?php

namespace App\Controller\Back;

use App\Entity\Chatbot;
use App\Entity\ChatbotMessages;
use App\Form\ChatbotMessagesType;
use App\Repository\ChatbotMessagesRepository;
use App\Service\ApiMailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/messages')]
class ChatbotMessagesController extends AbstractController
{
    #[Route('/', name: 'app_chatbot_messages_index', methods: ['GET'])]
    public function index(ChatbotMessagesRepository $chatbotMessagesRepository): Response
    {
        return $this->render('Back/chatbot_messages/index.html.twig', [
            'chatbot_messages' => $chatbotMessagesRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_chatbot_messages_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, ChatbotMessagesRepository $chatbotMessagesRepository, $id, MailerInterface $mailer): Response
    {

        $chatbot = $doctrine->getManager()->getRepository(Chatbot::class)->find($id);

        $chatbotMessage = new ChatbotMessages();

        $chatbotMessage->setChatbotId($chatbot);

        $form = $this->createForm(ChatbotMessagesType::class, $chatbotMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chatbotMessagesRepository->add($chatbotMessage);
            $email = ApiMailerService::send_email(
                $chatbot->getClientEmail(),
                "[Express] Problème #" . $chatbot->getId(),
                "admin-morphy-bot.html.twig",
                [
                    'expiration_date' => new \DateTime('+7 days'),
                    "message" => $chatbotMessage->getMessage(),
                ]
            );

            $mailer->send($email);
            return $this->redirectToRoute('app_chatbot_messages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/chatbot_messages/new.html.twig', [
            'chatbot_message' => $chatbotMessage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chatbot_messages_show', methods: ['GET'])]
    public function show(ChatbotMessages $chatbotMessage): Response
    {
        return $this->render('Back/chatbot_messages/show.html.twig', [
            'chatbot_message' => $chatbotMessage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chatbot_messages_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ChatbotMessages $chatbotMessage, ChatbotMessagesRepository $chatbotMessagesRepository): Response
    {
        $form = $this->createForm(ChatbotMessagesType::class, $chatbotMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chatbotMessagesRepository->add($chatbotMessage);
            return $this->redirectToRoute('app_chatbot_messages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/chatbot_messages/edit.html.twig', [
            'chatbot_message' => $chatbotMessage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chatbot_messages_delete', methods: ['POST'])]
    public function delete(Request $request, ChatbotMessages $chatbotMessage, ChatbotMessagesRepository $chatbotMessagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chatbotMessage->getId(), $request->request->get('_token'))) {
            $chatbotMessagesRepository->remove($chatbotMessage);
        }

        return $this->redirectToRoute('app_chatbot_messages_index', [], Response::HTTP_SEE_OTHER);
    }
}
