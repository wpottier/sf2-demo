<?php

namespace Mon\QcmBundle\Controller;

use Mon\QcmBundle\Entity\User;
use Mon\QcmBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('mon_qcm_homepage'));
        }

        $session = $request->getSession();
        $error = $request->attributes->get(Security::AUTHENTICATION_ERROR, null);

        if (!$error) {
            $error = $session->get(Security::AUTHENTICATION_ERROR, null);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }


        return $this->render('MonQcmBundle:Security:login.html.twig', [
            'error' => $error instanceof \Exception ? $error->getMessage() : '',
            'last_username' => $session->get(Security::LAST_USERNAME, null),
        ]);
    }

    public function registerAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') | $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERME')) {
            return $this->redirect($this->generateUrl('mon_qcm_homepage'));
        }

        $user = new User();

        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
            $user->setRoles(array('ROLE_USER'));

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add('success', 'Merci de vôtre inscription');

            return $this->redirectToRoute('mon_qcm_homepage');
        }

        return $this->render('MonQcmBundle:Security:register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
