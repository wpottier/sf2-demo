<?php

namespace Mon\QcmBundle\Controller;

use Mon\QcmBundle\Entity\AnswerProposition;
use Mon\QcmBundle\Entity\Qcm;
use Mon\QcmBundle\Entity\Question;
use Mon\QcmBundle\Form\QcmType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    public function listQcmAction()
    {
        $qcms = $this->getDoctrine()->getRepository('MonQcmBundle:Qcm')->loadAll(true, false);

        return $this->render('MonQcmBundle:Admin:listQcm.html.twig', [
            'qcms' => $qcms
        ]);
    }

    public function editQcmAction(Request $request, $id = null)
    {
        $qcm = new Qcm();
        if ($id != null) {
            $qcm = $this->getDoctrine()->getRepository('MonQcmBundle:Qcm')->loadOne($id, true, true);
        }

        if (!$qcm) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(new QcmType(), $qcm, [
            'action' => $request->getUri()
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $qcm->reindexPosition();

            $em = $this->getDoctrine()->getManager();

            if ($id === null) {
                $em->persist($qcm);
            }

            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'MCQ saved.');
            return $this->redirect($this->generateUrl('mon_qcm_homepage'));
        }

        return $this->render('MonQcmBundle:Admin:editQcm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
