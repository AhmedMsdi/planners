<?php

namespace BackOfficeBundle\Controller;

use PiBundle\Entity\User;
use PubliciteBundle\Entity\Publicite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SignalController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('PiBundle:User')->findAll();
       // $publicites2 = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('user' =>$this->getUser()));

        return $this->render('@BackOffice/signalisation/tousutili.html.twig', array(
            'utilisateurs' => $utilisateurs,

        ));
    }

    public function index2Action()
{

    $em = $this->getDoctrine()->getManager();
    $signalisations = $em->getRepository('ReviewBundle:Signaisation')->findAll();
    $utilisateurs = $em->getRepository('PiBundle:User')->findAll();
    // $publicites2 = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('user' =>$this->getUser()));



    return $this->render('@BackOffice/signalisation/signalutili.html.twig', array(
        'utilisateurs' => $utilisateurs,

    ));
}

    public function index3Action()
    {

        $em = $this->getDoctrine()->getManager();
        $signalisations = $em->getRepository('ReviewBundle:Signaisation')->findAll();
        $utilisateurs = $em->getRepository('PiBundle:User')->findAll();
        // $publicites2 = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('user' =>$this->getUser()));



        return $this->render('@BackOffice/signalisation/bloquerutili.html.twig', array(
            'utilisateurs' => $utilisateurs,

        ));
    }
    public function validertousAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(0);
        $this->getDoctrine()->getManager()->flush();
        $utilisateurs = $em->getRepository('PiBundle:User')->findBy(array('enabled' =>0));
        return $this->redirectToRoute('tousutilisat', array(
            'utilisateurs' => $utilisateurs,

        ));
    }

    public function refusertousAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setNbreSignal(0);
        $this->getDoctrine()->getManager()->flush();
        $utilisateurs = $em->getRepository('PiBundle:User')->findBy(array('enabled' =>0));
        return $this->redirectToRoute('tousutilisat', array(
            'utilisateurs' => $utilisateurs,

        ));
    }

    public function validerAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(0);
        $this->getDoctrine()->getManager()->flush();
        $utilisateurs = $em->getRepository('PiBundle:User')->findBy(array('enabled' =>0));
        return $this->redirectToRoute('signalutilisat', array(
            'utilisateurs' => $utilisateurs,

        ));
    }

    public function refuserAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setNbreSignal(0);
        $this->getDoctrine()->getManager()->flush();
        $utilisateurs = $em->getRepository('PiBundle:User')->findBy(array('enabled' =>0));
        return $this->redirectToRoute('signalutilisat', array(
            'utilisateurs' => $utilisateurs,

        ));
    }

    public function valider2Action(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(1);
        $user->setNbreSignal(0);
        $this->getDoctrine()->getManager()->flush();
        $utilisateurs = $em->getRepository('PiBundle:User')->findBy(array('enabled' =>0));
        return $this->redirectToRoute('bloquerutilisat', array(
            'utilisateurs' => $utilisateurs,

        ));
    }



}
