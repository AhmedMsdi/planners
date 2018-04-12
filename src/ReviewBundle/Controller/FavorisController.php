<?php

namespace ReviewBundle\Controller;

use PiBundle\Entity\User;
use PlanBundle\Entity\Plan;
use ReviewBundle\Entity\Favoris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FavorisController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $plan = $em->getRepository('PlanBundle:Plan')->findBy(array('user' =>$this->getUser()));
        $favoris = $em->getRepository('ReviewBundle:Favoris')->findBy(array('idUser' =>$this->getUser()));

        return $this->render('@Review/favoris/indexfavoris.html.twig', array(
            'plans' => $plan,
            'favoris' =>$favoris
        ));
    }

    public function favorisAction(Plan $plan){
        $favoris = new Favoris();
        $utilisateur = new User();
        $em = $this->getDoctrine()->getManager();
        $signal = $em->getRepository('ReviewBundle:Favoris')->findBy(array('idUser' =>$this->getUser(),'idPlan' =>$plan));
        if($signal==null ){
            $user = $this->getUser();


            $favoris->setIdUser($user);
            $favoris->setIdPlan($plan);

            $em = $this->getDoctrine()->getManager();
            $em->persist($favoris);

            $em->flush();
        }
        return $this->redirectToRoute('pi_homepage');
    }
}
