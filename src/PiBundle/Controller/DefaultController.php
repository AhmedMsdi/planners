<?php

namespace PiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DefaultController extends Controller
{

    private $tokenManager;



    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $numbers = range(1, 100);

        shuffle($numbers);
        $random_keys = array_rand($numbers, 4);


        $plans =$em->getRepository('PlanBundle:Plan')->findBy(array('etat'=>1)) ;

        $publicites = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('idPub' => $numbers,
                'etat' => 1)
            , null, 4);


        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;



        return $this->render('PiBundle:Default:index.html.twig',
            array(
                'csrf_token' => $csrfToken,
                'plans'=>$plans,

                'publicites' => $publicites,


            ));
    }

    public function profilAction()
    {
        return $this->render('PiBundle:Default:profil.html.twig'


        );
    }




}
