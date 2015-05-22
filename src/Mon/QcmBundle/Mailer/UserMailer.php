<?php

namespace Mon\QcmBundle\Mailer;

use Mon\QcmBundle\Entity\User;

class UserMailer extends AbstractMailer
{
    public function sendWelcome(User $user)
    {
        $message = $this
            ->create('Bienvenue sur MCQ')
            ->setTo($user->getEmail(), $user->getName())
            ->setBody($this->render('MonQcmBundle:Emails/User:welcome.html.twig', [
                'user' => $user
            ]));

        $this->send($message);
    }

    public function sendForgetPassword(User $user)
    {
        $message = $this
            ->create('Rappel de mot de passe')
            ->setTo($user->getEmail(), $user->getName())
            ->setBody($this->render('MonQcmBundle:Emails/User:forget-password.html.twig', [
                'user' => $user
            ]));

        $this->send($message);
    }
}