<?php

namespace ReviewBundle\Controller;

use PiBundle\Entity\User;
use PlanBundle\Entity\Plan;
use ReviewBundle\Entity\Favoris;
use ReviewBundle\ReviewBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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



    public function  newFavAction(Request $request){

        $em= $this->getDoctrine()->getManager();
        $favoris = new Favoris();

        $user=$em->getRepository('PiBundle:User')->find($request->get('idUser'));
        $plan=$em->getRepository('PlanBundle:Plan')->find($request->get('idPlan'));


       $signal = $em->getRepository('ReviewBundle:Favoris')->findBy(array('idUser' =>$user,'idPlan' =>$plan));

       var_dump($signal);
       if($signal==null ){

        $favoris->setIdPlan($plan);
        $favoris->setIdUser($user);

        $em->persist($favoris);
        $em->flush();
        $serializer = new Serializer([ new ObjectNormalizer()]);
        $formatted = $serializer-> normalize($favoris);

        }

        else if($signal!=null){

            $favoris=$em->getRepository('ReviewBundle:Favoris')->findOneBy(array('idUser' =>$user,'idPlan' =>$plan));

            $em->remove($favoris);
            $em->flush();
        }
        return new JsonResponse($formatted);

    }


}
