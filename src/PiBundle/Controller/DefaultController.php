<?php

namespace PiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{

    private $tokenManager;



    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $numbers = range(1, 100);

        shuffle($numbers);
        $random_keys = array_rand($numbers, 4);


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


            ));
    }

    public function profilAction()
    {
        return $this->render('PiBundle:Default:profil.html.twig'


        );
    }


    /*************************************************/


    public function allUserAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('PiBundle:User')
            ->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function FindLogin0IDAction($user)
    {
        $queryBuilder = $this->createQueryBuilder('f');
        $queryBuilder->select($queryBuilder->expr()->count('f'));
        $queryBuilder->where('f.User = :User')->setParameter('User', $user);

        $query = $queryBuilder->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;
    }
    public function FindLoginIDAction($login,$pswd)
    {

/* $query = $this->getEntityManager()->createQuery("SELECT count(u.id) FROM PiBundle:User u
        WHERE u.username='$login'    and   p.password='$pswd'  ");

        return $query->getResult();
,'password' =>$pswd
       */

        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('PiBundle:User')
            ->findBy(array('username' =>$login)
                ,null,6);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);


    }
}
