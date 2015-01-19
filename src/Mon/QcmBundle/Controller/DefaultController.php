<?php

namespace Mon\QcmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $participations = $this->getDoctrine()->getRepository('MonQcmBundle:Participation')->findBy(['user' => $this->getUser()]);

        return $this->render('MonQcmBundle:Default:index.html.twig', array('participations' => $participations));
    }

    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', 'text', [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('email', 'text', [
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('subject', 'text', [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('message', 'textarea', [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Send Mail

            $this->get('session')->getFlashBag()->add('success', 'Thanks for your message. We will get back to you as soon as possible.');
            return $this->redirect($request->getUri());
        }

        return $this->render('MonQcmBundle:Default:contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
