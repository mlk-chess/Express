<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if ($user->getStatus() === 0) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('Vous devez confirmer votre compte');
        }

        // user account is expired, the user may be notified
        if ($user->getStatus() === 1 && in_array("COMPANY", $user->getRoles())) {
            throw new CustomUserMessageAccountStatusException('Vous avez bien confirmé votre adresse e-mail mais vous devez attendre que l\'administrateur confirme votre compte');
        }

    }
}