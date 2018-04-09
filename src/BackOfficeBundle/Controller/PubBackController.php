<?php

namespace BackOfficeBundle\Controller;

use PubliciteBundle\Entity\Publicite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PubBackController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicites = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('etat' =>0));
       // $publicites2 = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('user' =>$this->getUser()));

        return $this->render('@BackOffice/publicite/demandePub.html.twig', array(
            'publicites' => $publicites,

        ));
    }

    public function validerAction(Request $request, Publicite $publicite)
    {
        $em = $this->getDoctrine()->getManager();
        $publicite->setEtat(1);
        $this->getDoctrine()->getManager()->flush();
        $publicites = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('etat' =>0));
        return $this->redirectToRoute('demandePub', array(
            'publicites' => $publicites,

        ));
    }

    public function refuserAction(Request $request, Publicite $publicite)
    {
        $em = $this->getDoctrine()->getManager();
        $publicite->setEtat(-1);
        $this->getDoctrine()->getManager()->flush();
        $publicites = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('etat' =>0));
        return $this->redirectToRoute('demandePub', array(
            'publicites' => $publicites,

        ));
    }



}
