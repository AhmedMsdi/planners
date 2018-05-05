<?php

namespace PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function AhmedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $planaaa = $em->getRepository('PlanBundle:Plan')->findBy(array('user' =>$this->getUser()));

//Notif

        $ems = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $plans = $ems->getRepository('PlanBundle:Plan')->NotifAction($user);

        foreach($plans as $plan) {
            $libplan=  $plan->getlibelle();
            $idp = $plan->getidP();
            $messagenotif = $idp . '-' . $libplan . ' valider avec succée !!!'  ;
            $this->get('session')->getFlashBag()->add(
                'notice',
                $messagenotif
            );

        }
         //$this->get('session')->getFlashBag()-> clear();
        return $this->render('PlanBundle:plan:indexProfil.html.twig', array(
            'plans' => $planaaa
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
