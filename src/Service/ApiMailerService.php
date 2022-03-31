<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class ApiMailerService
{
    static function send_email($to, $subject, $template, $context)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@express.com', 'Express'))
            ->to($to)
            ->htmlTemplate('Emails/'.$template)
            ->context($context)
            ->subject($subject);

        return $email;
    }
}