<?php

namespace App\Controller\Front\chatbot;

use App\Entity\User;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Cache\SymfonyCache;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;


class Chatbot extends AbstractController{

    /**
     * @Route("/message", name="message")
     */
    function messageAction(Request $request, ManagerRegistry $doctrine)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = [
        ];

        $adapter = new FilesystemAdapter();
        $botman = BotManFactory::create($config, new SymfonyCache($adapter));

        $botman->hears('help', function($bot) use ($doctrine) {
            $conv = new HelpConversationController;
            $bot->startConversation($conv);
        });

        $botman->hears('save', function(BotMan $bot) use ($doctrine, $request) {
            if(
                isset($_SESSION["client_email"], $_SESSION["client_problem"])
            ) {
                $em = $doctrine->getManager();
                $user = $em->getRepository(User::class)->findOneBy(["email" => $_SESSION["client_email"]]);
                if ($user) {
                    $chatbot = new \App\Entity\Chatbot();
                    $chatbot->setClientName($_SESSION["client_name"]);
                    $chatbot->setClientProblem($_SESSION["client_problem"]);
                    $chatbot->setDescription($_SESSION["client_description"] ?? "");
                    $chatbot->setClientEmail($_SESSION["client_email"]);
                    $chatbot->setStatus(0);
                    $em->persist($chatbot);
                    $em->flush();
                    $bot->typesAndWaits(0.8);
                    $bot->reply('Discussion enregistrée !');
                    $bot->typesAndWaits(1.1);
                    $bot->reply('Tapez "help" pour réaliser une autre demande');
                } else {
                    $bot->typesAndWaits(0.5);
                    $bot->reply("Votre adresse mail n'a pas été reconnue... \n\r  Tapez \"help\" pour recommencer. ");
                }
            }else{
                $bot->typesAndWaits(0.9);
                $bot->reply('Un problème est survenu, tapez "help"...');
            }


            unset($_SESSION["client_email"], $_SESSION["client_problem"], $_SESSION["client_description"], $_SESSION["client_name"]);

        })->stopsConversation();

        $botman->fallback(function($bot) {
            $bot->typesAndWaits(0.6);
            $bot->reply('Tapez "help" ou "save" pour arrêter une conversation');
        });

        $botman->listen();

        return new Response();
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('Chatbot/index.html.twig');
    }

    /**
     * @Route("/chatframe", name="chatframe")
     */
    public function chatframeAction(Request $request)
    {
        return $this->render('Chatbot/chatbot.html.twig');
    }
}