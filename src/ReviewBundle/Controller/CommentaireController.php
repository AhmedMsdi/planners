<?php

namespace ReviewBundle\Controller;

use PlanBundle\Entity\Plan;
use PubliciteBundle\Entity\Publicite;
use ReviewBundle\Entity\Commentaire;
use ReviewBundle\Entity\Signaisation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Commentaireomar controller.
 *
 */
class CommentaireController extends Controller
{

    public function allAction()
    {
        $commentaires = $this->getDoctrine()->getManager()
                ->getRepository('ReviewBundle:Commentaire')
                ->findAll();

        $serializer = new Serializer([ new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commentaires);

        return new JsonResponse($formatted);
    }


    public function findAction($id){
        $commentaires= $this->getDoctrine()->getManager()
            ->getRepository('ReviewBundle:Commentaire')
            ->find($id);

        $serialzer = new Serializer([ new ObjectNormalizer()]);
        $formatted = $serialzer -> normalize($commentaires);

        return new JsonResponse($formatted);
    }



    public function  new2Action(Request $request){

        $em= $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();

        $user=$em->getRepository('PiBundle:User')->find($request->get('id'));
        $plan=$em->getRepository('PlanBundle:Plan')->find($request->get('idPlan'));

        $commentaire ->setContenu($request->get('contenu'));
        $commentaire->setIdUser($user);
        $commentaire->setIdP($plan);

        $em->persist($commentaire);
        $em->flush();
        $serializer = new Serializer([ new ObjectNormalizer()]);
        $formatted = $serializer-> normalize($commentaire);

        return new JsonResponse($formatted);

    }


    public function delete2Action($id){
        $em=$this->getDoctrine()->getManager();
           $commentaire=$em->getRepository(Commentaire::class)->find($id);

        $em->remove($commentaire);
        $em->flush();

        return new Response("true");
    }



    /*
    public function deleteAction($id)
    {


        $em=$this->getDoctrine()->getManager();
        $commentaire=$em->getRepository(Commentaire::class)->find($id);

        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute('Details_plans',array('idP' => $commentaire->getIdP()->getIdP())  );



    }*/




    /**
     * Lists all commentaire entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request->attributes->get('idP');
        $commentaires = $em->getRepository('ReviewBundle:Commentaire')->findAll();

        return $this->render('@Review/commentaire/index.html.twig', array(
            'commentaires' => $commentaires,
            'idP'=>$request,

        ));
    }

    public function ajoutAction(Request $request,Plan $plan)
    {

        $user = $this->getUser();

        if($request->isXmlHttpRequest() && $request->isMethod('post')) {
            $commentaire =new Commentaire();
            $em=$this->getDoctrine()->getManager();
            $plan=$em->getRepository('PlanBundle:Plan')->find($plan);

            $contenu=$request->get('contenu');


            $commentaire->setContenu($contenu);
            $commentaire->setIdUser($user);
            $commentaire->setIdP($plan);
            $em->persist($commentaire);
            $em->flush();

            $comaffiche = $em->getRepository('ReviewBundle\Entity\Commentaire')->findAll();
            $response = $this->renderView('@Review/commentaire/indexcomm.html.twig',array('all'=>$comaffiche));
            return  new JsonResponse($response) ;
        }

        return new JsonResponse(array("status"=>true));

    }





    /**
     * Creates a new commentaire entity.
     *
     */
    public function newAction(Request $request, Publicite $publicite)
    {
        $commentaire = new Commentaire();

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('ReviewBundle\Form\CommentaireType', $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $id=$request->get('id_plan');
           // $plan=$em->getRepository('PlanBundle:Plan')->find(80);
            $commentaire->setIdUser($user);
            //$commentaire->setIdPlan($plan);
            $commentaire->setIdPlan($id);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('commentaire_show', array('id' => $commentaire->getId()));
        }

        return $this->render('@Review/commentaire/new.html.twig', array(
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentaire entity.
     *
     */
    public function showAction(Commentaire $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);

        return $this->render('@Review/commentaire/show.html.twig', array(
            'commentaire' => $commentaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaire entity.
     *
     */
    public function editAction(Request $request, Commentaire $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);
        $editForm = $this->createForm('ReviewBundle\Form\CommentaireType', $commentaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Details_plans',array('idP' => $commentaire->getIdP()->getIdP())  );
        }

        return $this->render('@Review/commentaire/edit.html.twig', array(
            'commentaire' => $commentaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentaire entity.
     *
     */
    public function deleteAction($id)
    {


        $em=$this->getDoctrine()->getManager();
        $commentaire=$em->getRepository(Commentaire::class)->find($id);

        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute('Details_plans',array('idP' => $commentaire->getIdP()->getIdP())  );



    }






    /**
     * Creates a form to delete a commentaire entity.
     *
     * @param Commentaire $commentaire The commentaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commentaire $commentaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentaire_delete', array('id' => $commentaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
