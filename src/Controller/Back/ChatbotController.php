<?php

namespace App\Controller\Back;

use App\Entity\Chatbot;
use App\Form\Chatbot1Type;
use App\Form\ChatbotStatusType;
use App\Repository\ChatbotMessagesRepository;
use App\Repository\ChatbotRepository;
use App\Service\ApiMailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/chatbot')]
class ChatbotController extends AbstractController
{
    #[Route('/', name: 'app_chatbot_index', methods: ['GET'])]
    public function index(ChatbotRepository $chatbotRepository): Response
    {
        return $this->render('Back/chatbot/index.html.twig', [
            'chatbots' => $chatbotRepository->findAll(),
        ]);
    }



    #[Route('/{id}', name: 'app_chatbot_show', methods: ['GET'])]
    public function show(Chatbot $chatbot): Response
    {
        return $this->render('Back/chatbot/show.html.twig', [
            'chatbot' => $chatbot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chatbot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chatbot $chatbot, ChatbotRepository $chatbotRepository, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ChatbotStatusType::class, $chatbot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chatbotRepository->add($chatbot);
            if ($chatbot->getStatus() === 0) $status = "ouvert. Un technicien ne va pas tarder à vous recontacter.";
            else if ($chatbot->getStatus() === 1) $status = "en progression. Un technicien prend en charge votre demande";
            else if ($chatbot->getStatus() === 2) $status = "a été cloturé. Votre problème a été résolu. S'il ne l'a pas été, n'hésitez à nous recontacter.";
            else $status = "a été supprimé";
            $email = ApiMailerService::send_email(
                $chatbot->getClientEmail(),
                "[Express - MorphyBot] Statut de votre problème #" . $chatbot->getId(),
                "admin-change-status-chatbot.html.twig",
                [
                    "status" => $status,
                    "username" => $chatbot->getClientName(),
                ]
            );

            $mailer->send($email);
            return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/chatbot/edit.html.twig', [
            'chatbot' => $chatbot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chatbot_delete', methods: ['POST'])]
    public function delete(Request $request, Chatbot $chatbot, ChatbotRepository $chatbotRepository, MailerInterface $mailer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chatbot->getId(), $request->request->get('_token'))) {
            $chatbot->setStatus(-1);
            $chatbotRepository->add($chatbot);
            $email = ApiMailerService::send_email(
                $chatbot->getClientEmail(),
                "[Express - MorphyBot] Statut de votre problème #" . $chatbot->getId(),
                "admin-change-status-chatbot.html.twig",
                [
                    "status" => "a été supprimé.",
                    "username" => $chatbot->getClientName(),
                ]
            );
            $mailer->send($email);

            return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
    }
}
