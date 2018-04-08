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
}
