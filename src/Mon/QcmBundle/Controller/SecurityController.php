<?php

namespace Mon\QcmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('mon_qcm_homepage'));
        }

        $error = null;

        $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR, null);

        if (!$error) {
            $error = $request->getSession()->get(SecurityContextInterface::AUTHENTICATION_ERROR, null);
            $request->getSession()->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }


        return $this->render('MonQcmBundle:Security:login.html.twig', [
            'error' => $error instanceof \Exception ? $error->getMessage() : ''
        ]);
    }
}
