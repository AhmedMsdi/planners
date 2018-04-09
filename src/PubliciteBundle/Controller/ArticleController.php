<?php

namespace PubliciteBundle\Controller;

use PubliciteBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('PubliciteBundle:Article')->findBy(array('etat' =>1));

        return $this->render('@Publicite/article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    public function indexPersoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('PubliciteBundle:Article')->findBy(array('user' =>$this->getUser()));

        return $this->render('@Publicite/article/indexPerso.html.twig', array(
            'articles' => $articles,
        ));
    }




    public function chercherAction(Request $request)
    {    $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('PubliciteBundle:Article')->findBy(array('user' =>$this->getUser()));


        if($request->isXmlHttpRequest() && $request->isMethod('post') && $request->get('text')!=null){

            $text =$request->get('text');
            $em = $this->getDoctrine()->getEntityManager();
            $query =$em->getRepository('PubliciteBundle:Article')->createQueryBuilder('u');
            $annonce= $query->where($query->expr()->like('u.titre',':p'))
                ->setParameter('p','%'.$text.'%')
                ->getQuery()->getResult();

            $response = $this->renderView('@Publicite/article/search.html.twig',array('articles'=>$annonce));
            return  new JsonResponse($response) ;
        }elseif ( $request->get('text')==null){
            $em = $this->getDoctrine()->getEntityManager();
            $query =$em->getRepository('PubliciteBundle:Article')->createQueryBuilder('u');
            $annonce= $query
                ->getQuery()->getResult();
            $response = $this->renderView('@Publicite/article/search.html.twig',array('articles'=>$articles));
            return  new JsonResponse($response) ;
        }

        return new JsonResponse(array("status"=>true));

    }
    /**
     * Creates a new article entity.
     *
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $user = $this->getUser();
        $form = $this->createForm('PubliciteBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setDatecreation(new \DateTime());

            $file = $article->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored

            $path = "C:/wamp64/www/planners/web" ;

            $file->move(
                $path,
                $fileName
            );
            $article->setImage($fileName);
            $article->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('@Publicite/article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('@Publicite/article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('PubliciteBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $article->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();


            // Move the file to the directory where brochures are stored

            $path = "C:/wamp64/www/planners/web" ;

            $file->move(
                $path,
                $fileName
            );

            $article->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('@Publicite/article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     */
    public function deleteAction( Article $article)
    {

        $em=$this->getDoctrine()->getManager();
     //   $commentaire=$em->getRepository(Article::class)->find($id);

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('article_index' );

    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
