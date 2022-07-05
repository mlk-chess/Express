<?php

namespace App\Controller\Back;

use App\Entity\Chatbot;
use App\Form\Chatbot1Type;
use App\Form\ChatbotStatusType;
use App\Repository\ChatbotMessagesRepository;
use App\Repository\ChatbotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function edit(Request $request, Chatbot $chatbot, ChatbotRepository $chatbotRepository): Response
    {
        $form = $this->createForm(ChatbotStatusType::class, $chatbot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chatbotRepository->add($chatbot);
            return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/chatbot/edit.html.twig', [
            'chatbot' => $chatbot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chatbot_delete', methods: ['POST'])]
    public function delete(Request $request, Chatbot $chatbot, ChatbotRepository $chatbotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chatbot->getId(), $request->request->get('_token'))) {
            $chatbotRepository->remove($chatbot);
        }

        return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
    }
}
