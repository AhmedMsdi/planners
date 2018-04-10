<?php

namespace PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function AhmedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $plan = $em->getRepository('PlanBundle:Plan')->findBy(array('user' =>$this->getUser()));

        return $this->render('PlanBundle:plan:indexProfil.html.twig', array(
            'plans' => $plan
        ));
    }


    public function delete3Action($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository("PlanBundle:Plan")->find($idP);
        $em->remove($modele);
        $em->flush();
        return $this->redirectToRoute('Profil_index');
    }
}
