<?php

namespace App\Controller\Front\chatbot;

use App\Entity\User;
use App\Service\HelperChatbot;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HelpConversationController extends Conversation
{
    protected $firstname;
    protected $email;

    public function stopsConversation(IncomingMessage $message)
    {

        if ($message->getText() == 'stop') return true;
        return false;
    }

    public function askFirstname()
    {
        $this->ask('Salut ! Quel est votre nom?', function(Answer $answer) {
            $this->firstname = $answer->getText();
            $this->say('Bienvenue '.$this->firstname);
            $_SESSION["client_name"] = $this->firstname;

            $this->askEmail();

        });
    }

    public function askEmail()
    {
        $this->ask($this->firstname . ', quel est votre mail?', function(Answer $answer) {
            $this->email = $answer->getText();

            $_SESSION['client_email'] = $this->email;

            $this->askProblem();
        });

    }

    public function askProblem()
    {
        $question = Question::create('Votre problème concerne...')
            ->fallback("Une erreur s'est produite, réessayez ultérieurement...")
            ->callbackId('create_database')
            ->addButtons([
                Button::create('une réservation')->value('0'),
                Button::create('un paiement...')->value('1'),
                Button::create('un bug sur le site...')->value('2'),
                Button::create('Autre...')->value('3'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue();
                $selectedText = $answer->getText();
                $this->say('Votre demande a été enregistrée '. $this->firstname .  ', un technicien ne va pas tarder à vous recontacter au mail suivant : '. $this->email);

                $_SESSION["client_problem"] = $selectedValue;
            }
        });
    }
    public function run()
    {
        $this->askFirstname();
    }
}