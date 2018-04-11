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
        $random_keys=array_rand($numbers,4);


            $publicites = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('idPub' =>$numbers,'etat' =>1)
                ,null,4);
        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('id' =>$numbers,'enable' =>1)
            ,null,6);
        $plans = $em->getRepository('PlanBundle:Plan')->findBy(array('idP' =>$numbers,'etat' =>1)
            ,null,6);
        $events = $em->getRepository('EvennementBundle:Evennement')->findBy(array('id' =>$numbers,'etat' =>1)
            ,null,6);

        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        return $this->render('PiBundle:Default:index.html.twig',
            array(
                'csrf_token' => $csrfToken,
             'publicites' => $publicites,
                'hebergements' =>$hebergements,
                'plans' => $plans,
                'events' => $events

            ) );
    }
    public function profilAction()
    {
        return $this->render('PiBundle:Default:profil.html.twig'


    );
    }
}
