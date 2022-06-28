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
            $em = $doctrine->getManager();
            $user = $em->getRepository(User::class)->findOneBy(["email"=> "mkajeiou3@myges.fr"]);
            $user ? $bot->reply("OK") : $bot->reply("KO");
        });

        $botman->hears('stop', function(BotMan $bot) {
            $bot->reply('Discussion réinitialisée');
        })->stopsConversation();

        $botman->fallback(function($bot) {
            $bot->reply('Désolé, je ne comprends pas tout !');
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