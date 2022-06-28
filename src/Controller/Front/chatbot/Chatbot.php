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

        $botman->hears('save', function(BotMan $bot) use ($doctrine) {
            if(
                isset($_SESSION["client_email"], $_SESSION["client_problem"], $_SESSION["client_description"])
            ) {
                $em = $doctrine->getManager();
                $user = $em->getRepository(User::class)->findOneBy(["email" => $_SESSION["client_email"]]);
                if ($user) {
                    $bot->reply('Discussion enregistrée !');
                    $bot->reply('Tapez "help" pour réaliser une autre demande');
                } else {
                    $bot->reply("Votre adresse mail n'a pas été reconnue... \n\r  Tapez \"help\" pour recommencer. ");
                }
            }else
                $bot->reply('Un problème est survenu, tapez "help"...');

            unset($_SESSION["client_email"], $_SESSION["client_problem"], $_SESSION["client_description"], $_SESSION["client_name"]);

        })->stopsConversation();

        $botman->fallback(function($bot) {
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