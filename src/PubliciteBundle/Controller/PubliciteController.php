<?php

namespace PubliciteBundle\Controller;

use Knp\Snappy\Pdf;
use PubliciteBundle\Entity\Publicite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Publicite controller.
 *
 */
class PubliciteController extends Controller
{
    /**
     * Lists all publicite entities.
     *
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $publicites = $em->getRepository('PubliciteBundle:Publicite')->findAll();
        $publicites2 = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('user' =>$this->getUser()));

        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $publicites2,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );


        return $this->render('@Publicite/publicite/index.html.twig', array(
            'publicites2' => $result,
            'publicites' => $publicites2,

        ));

    }




    public function chercherAction(Request $request)
    {    $em = $this->getDoctrine()->getManager();

        $publicites = $em->getRepository('PubliciteBundle:Publicite')->findBy(array('user' =>$this->getUser()));

        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $publicites,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );


        if($request->isXmlHttpRequest() && $request->isMethod('post') && $request->get('text')!=null){

            $text =$request->get('text');
            $em = $this->getDoctrine()->getEntityManager();
            $query =$em->getRepository('PubliciteBundle:Publicite')->createQueryBuilder('u');
            $annonce= $query->where($query->expr()->like('u.text',':p'))
                ->setParameter('p','%'.$text.'%')
                ->getQuery()->getResult();

            $response = $this->renderView('@Publicite/publicite/search.html.twig',array('all'=>$annonce));
            return  new JsonResponse($response) ;
        }elseif ( $request->get('text')==null){
            $em = $this->getDoctrine()->getEntityManager();
            $query =$em->getRepository('PubliciteBundle:Publicite')->createQueryBuilder('u');
            $annonce= $query
              ->getQuery()->getResult();
            $response = $this->renderView('@Publicite/publicite/search.html.twig',array('all'=>$result));
            return  new JsonResponse($response) ;
    }

        return new JsonResponse(array("status"=>true));

    }

    public function chartAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $publicites = $em->getRepository('PubliciteBundle:Publicite')->findAll();
        return $this->render('@Publicite/publicite/chart.html.twig', array(
        'publicites' => $publicites,
    ));
    }

    /**
     * Creates a new publicite entity.
     *
     */
    public function newAction(Request $request)
    {
        $publicite = new Publicite();
        $user = $this->getUser();
        $form = $this->createForm('PubliciteBundle\Form\PubliciteType', $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $publicite->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $publicite->setUser($user);

            // Move the file to the directory where brochures are stored

            $path = "C:/wamp64/www/planners/web" ;

           $file->move(
                $path,
                $fileName
            );
            $publicite->setImage($fileName);
            /****/
            $publicite->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($publicite);
            $em->flush();

            return $this->redirectToRoute('publicite_show', array('idPub' => $publicite->getIdpub()));
        }

        return $this->render('@Publicite/publicite/new.html.twig', array(
            'publicite' => $publicite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publicite entity.
     *
     */
    public function showAction(Publicite $publicite)
    {
        $deleteForm = $this->createDeleteForm($publicite);
        if($publicite->getUser() != $this->getUser()){
            $publicite->setNbClick($publicite->getNbClick()+1);
        }elseif ($this->getUser()==null){
            $publicite->setNbClick($publicite->getNbClick()+1);
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->render('@Publicite/publicite/show.html.twig', array(
            'publicite' => $publicite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publicite entity.
     *
     */
    public function editAction(Request $request, Publicite $publicite)
    {
        $deleteForm = $this->createDeleteForm($publicite);

        $fileName = $publicite->getImage();
        $publicite->setImage($fileName);

        $editForm = $this->createForm('PubliciteBundle\Form\PubliciteType', $publicite);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $publicite->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();


            // Move the file to the directory where brochures are stored

            $path = "C:/wamp64/www/planners/web" ;

            $file->move(
                $path,
                $fileName
            );

            $publicite->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicite_show', array('idPub' => $publicite->getIdpub()));
        }

        return $this->render('@Publicite/publicite/edit.html.twig', array(
            'publicite' => $publicite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function pdfAction()
    {   $em = $this->getDoctrine()->getManager();
        $publicite =$em->getRepository('PubliciteBundle:Publicite')->findAll();
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('@Publicite/publicite/pdf.html.twig', array('publicites'=>$publicite
            //..Send some data to your view if you need to //
        ));

        $filename = 'mesPublicités';


        return new Response(

            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        )
        ;
    }
    /**
     * Deletes a publicite entity.
     *
     */
    public function deleteAction(Publicite $publicite)
    {
        $em=$this->getDoctrine()->getManager();
        //   $commentaire=$em->getRepository(Article::class)->find($id);

        $em->remove($publicite);
        $em->flush();

        return $this->redirectToRoute('publicite_index' );
    }

    /**
     * Creates a form to delete a publicite entity.
     *
     * @param Publicite $publicite The publicite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicite $publicite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publicite_delete', array('idPub' => $publicite->getIdpub())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
