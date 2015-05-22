<?php

namespace Mon\QcmBundle\Mailer;

use Mon\QcmBundle\Entity\Participation;

class QcmMailer extends AbstractMailer
{
    /**
     * @param Participation $participation
     */
    public function sendInviteParticipation(Participation $participation)
    {
        $user = $participation->getUser();
        $message = $this
            ->create('Invitation à un test')
            ->setTo($user->getEmail(), $user->getName())
            ->setBody($this->render('MonQcmBundle:Emails/Qcm:forget-password.html.twig', [
                'user' => $user,
                'participation' => $participation,
            ]));

        $this->send($message);
    }

    /**
     * @param Participation $participation
     */
    public function sendParticipationResult(Participation $participation)
    {
        $user = $participation->getUser();
        $message = $this
            ->create('Résultats de votre test')
            ->setTo($user->getEmail(), $user->getName())
            ->setBody($this->render('MonQcmBundle:Emails/Qcm:forget-password.html.twig', [
                'user' => $user,
                'participation' => $participation,
            ]));

        $this->send($message);
    }
}