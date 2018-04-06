<?php

namespace ReviewBundle\Controller;

use ReviewBundle\Entity\Commentaire;
use ReviewBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{


    public function ajoutercomAction(Request $request)
    {
        $commentaire= new Commentaire();
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            //return $this->redirectToRoute()
        }

        return $this->render("ReviewBundle:Commentaire:ajoutcommentaire.html.twig",array(

            'form'=>$form->createView()
        ));
    }

}
