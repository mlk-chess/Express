<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ApiMailerService
{
    static function send_email($to, $subject, $template, $context)
    {
        $email = (new TemplatedEmail())
            ->from('no-reply@express.com')
            ->to($to)
            ->htmlTemplate('Emails/'.$template)
            ->context($context)
            ->subject($subject);

        return $email;
    }
}