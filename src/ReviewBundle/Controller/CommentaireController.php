<?php

namespace ReviewBundle\Controller;

use PlanBundle\Entity\Plan;
use PubliciteBundle\Entity\Publicite;
use ReviewBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commentaireomar controller.
 *
 */
class CommentaireController extends Controller
{
    /**
     * Lists all commentaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('ReviewBundle:Commentaire')->findAll();

        return $this->render('@Review/commentaire/index.html.twig', array(
            'commentaires' => $commentaires,

        ));
    }

    public function ajoutAction(Request $request,Plan $plan)
    {
        $user = $this->getUser();
        $plan = $this->getPlan();
        if($request->isXmlHttpRequest() && $request->isMethod('post')) {
            $commentaire =new Commentaire();
            $em=$this->getDoctrine()->getManager();
            $plan=$em->getRepository('PlanBundle:Plan')->find($plan);

            $contenu=$request->get('contenu');






            $commentaire->setContenu($contenu);
            $commentaire->setIdUser($user);
            $commentaire->setIdPlan($plan);
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

            return $this->redirectToRoute('commentaire_edit', array('id' => $commentaire->getId()));
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

        return $this->redirectToRoute('publicite_show',array('idPub' => 2)  );



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
