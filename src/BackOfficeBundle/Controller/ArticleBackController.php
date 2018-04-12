<?php

namespace BackOfficeBundle\Controller;

use PubliciteBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleBackController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('PubliciteBundle:Article')->findBy(array('etat' =>0));
       // $publicites2 = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('user' =>$this->getUser()));

        return $this->render('@BackOffice/article/demandeArticle.html.twig', array(
            'articles' => $articles,

        ));
    }

    public function validerAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $article->setEtat(1);
        $this->getDoctrine()->getManager()->flush();
        $articles = $em->getRepository('PubliciteBundle:Article')->findBy(array('etat' =>0));
        return $this->redirectToRoute('demandeArticle', array(
            'articles' => $articles,

        ));
    }

    public function refuserAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $article->setEtat(-1);
        $this->getDoctrine()->getManager()->flush();
        $articles = $em->getRepository('PubliciteBundle:Article')->findBy(array('etat' =>0));
        return $this->redirectToRoute('demandeArticle', array(
            'articles' => $articles,

        ));
    }



}
