<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;


class Chatbot extends AbstractController{

    /**
     * @Route("/message", name="message")
     */
    function messageAction(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        // Configuration for the BotMan WebDriver
        $config = [];

        // Create BotMan instance
        $botman = BotManFactory::create($config);




        // Give the bot some things to listen for.
        $botman->hears('(hello|hi|hey)', function (BotMan $bot) {
            $bot->reply('Hello!');
        });

        // Set a fallback
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I did not understand.');
        });

        // Start listening
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