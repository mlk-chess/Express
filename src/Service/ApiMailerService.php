<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ApiMailerService
{
    static function send_email($to, $subject, $template, $context)
    {
        $email = (new TemplatedEmail())
            ->from('express@express.com')
            ->to($to)
            ->htmlTemplate('Emails/'.$template)
            ->context($context)
            ->subject($subject);

        return $email;
    }
}