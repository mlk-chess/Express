<?php

namespace App\Controller\Front\chatbot;

use App\Entity\User;
use App\Service\Helper;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;


class HelpConversationController extends Conversation
{
    protected $firstname;
    protected $email;

    public function stopsConversation(IncomingMessage $message)
    {

        if ($message->getText() == 'stop') return true;
        return false;
    }

    public function run()
    {
        $this->askFirstname();
    }

    public function askFirstname()
    {
        $this->bot->typesAndWaits(1);
        $this->ask('Salut ! Quel est votre nom?', function (Answer $answer) {
            $this->firstname = $answer->getText();
            $this->say('Bienvenue ' . $this->firstname);
            $_SESSION["client_name"] = $this->firstname;

            $this->askEmail();

        });
    }

    public function askEmail()
    {
        $this->bot->typesAndWaits(1.2);
        $this->ask('Quelle est votre adresse mail? (Assurez-vous qu\'elle soit bien enregistrée sur notre site)', function (Answer $answer) {
            $this->email = $answer->getText();

            $_SESSION['client_email'] = $this->email;

            $this->askProblem();
        });

    }

    public function askProblem()
    {
        $this->bot->typesAndWaits(1.5);
        $question = Question::create('Votre problème concerne...')
            ->fallback("Une erreur s'est produite, réessayez ultérieurement...")
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

                $this->askDescription($answer->getValue());
                $_SESSION["client_problem"] = $selectedValue;
            }
        });
        return true;
    }

    public function askDescription($problem)
    {
        $this->bot->typesAndWaits(1.1);
        $this->ask('Décrivez nous en quelques mots le problème que vous avez rencontré', function (Answer $answer) use ($problem) {
            $this->bot->typesAndWaits(1.1);
            if (strlen($answer->getText()) < 250) {
                $_SESSION["client_description"] = $answer->getText();
                $this->say('Très bien, tapez "save" et un technicien ne tardera pas à vous recontacter à l\'adresse mail suivante : ' . $this->email);
            } else {
                $this->say("Description trop longue, vous ne devez pas dépasser 250 caractères.");
                $this->askDescription($problem);
            }
            $_SESSION["client_problem"] = $problem;
        });
    }
}