<?php

namespace Mon\QcmBundle\Controller;

use Mon\QcmBundle\Entity\AnswerProposition;
use Mon\QcmBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ParticipationController extends Controller
{
    /**
     * @param $participationKey
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($participationKey)
    {
        $participation = $this->getDoctrine()->getRepository('MonQcmBundle:Participation')->findOneBy(['user' => $this->getUser(), 'participationKey' => $participationKey]);

        if (!$participation || $participation->getQcm()->getQuestions()->count() == 0) {
            throw $this->createNotFoundException();
        }

        /** @var Question $question */
        $question = $participation->getQcm()->getQuestions()->first();

        $formBuilder = $this->createFormBuilder([
            'action' => $this->generateUrl('mon_qcm_participation_view', ['participationKey' => $participationKey])
        ]);

        $choices = [];
        foreach ($question->getPropositions() as $proposition) {
            /** @var AnswerProposition $proposition */
            $choices[$proposition->getId()] = $proposition->getAnswer();
        }

        $formBuilder->add('answer', 'choice', [
            'choices' => $choices,
            'required' => false,
            'multiple' => true,
            'expanded' => true,
        ]);

        $form = $formBuilder->getForm();

        return $this->render('MonQcmBundle:Participation:view.html.twig', [
            'participation' => $participation,
            'question' => $question,
            'form' => $form->createView()
        ]);
    }
}