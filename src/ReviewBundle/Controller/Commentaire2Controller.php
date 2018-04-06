<?php

namespace ReviewBundle\Controller;

use PiBundle\Entity\User;
use ReviewBundle\Entity\Commentaire;
use ReviewBundle\Form\CommentaireType;
use ReviewBundle\ReviewBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PlanBundle\Entity\Plan;

class CommentaireController extends Controller
{


    public function ajoutercomAction(Request $request)
    {
        $id_currentuser=1;

        $em = $this->getDoctrine()->getManager();
        $commentaire= new Commentaire();

        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()){

            $user=$em->getRepository('PiBundle:User')->find($id_currentuser);
            $plan=$em->getRepository('PlanBundle:Plan')->find(80);

            $commentaire->setIdUser($user);
            $commentaire->setIdPlan($plan);
            $em=$this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            //return $this->redirectToRoute()
        }

        return $this->render("ReviewBundle:Commentaire:ajoutcommentaire.html.twig",array(

            'form'=>$form->createView()
        ));
    }



    public function updatecomAction(Request $request, $id){

        $em=$this->getDoctrine()->getManager();
        $commentaire=$em->getRepository("ReviewBundle:Commentaire")->find($id);

    }

}
