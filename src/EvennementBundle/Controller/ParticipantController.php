<?php

namespace EvennementBundle\Controller;

use EvennementBundle\Entity\Evennement;
use EvennementBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Participant controller.
 *
 * @Route("participant")
 */
class ParticipantController extends Controller
{
    /**
     * Lists all participant entities.
     *
     * @Route("/", name="participant_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $participants = $em->getRepository('EvennementBundle:Participant')->findAll();

        return $this->render('participant/index.html.twig', array(
            'participants' => $participants,
        ));
    }

    /**
     * Creates a new participant entity.
     *
     * @Route("/new/{id}", name="participant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,Evennement $evennement,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $participant = new Participant();
        $form = $this->createForm('EvennementBundle\Form\ParticipantType', $participant);
        $event=$em->getRepository('EvennementBundle:Evennement')->find($evennement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $participant->setUser($this->getUser());
            $participant->setEvent($event);
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('evennement_info',array('id'=>$id));
        }

        return $this->render('participant/new.html.twig', array(
            'participant' => $participant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a participant entity.
     *
     * @Route("/{id}", name="participant_show")
     * @Method("GET")
     */
    public function showAction(Participant $participant)
    {
        $deleteForm = $this->createDeleteForm($participant);

        return $this->render('participant/show.html.twig', array(
            'participant' => $participant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing participant entity.
     *
     * @Route("/{id}/edit", name="participant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Participant $participant)
    {
        $deleteForm = $this->createDeleteForm($participant);
        $editForm = $this->createForm('EvennementBundle\Form\ParticipantType', $participant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participant_edit', array('id' => $participant->getId()));
        }

        return $this->render('participant/edit.html.twig', array(
            'participant' => $participant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a participant entity.
     *
     * @Route("/{id}", name="participant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Participant $participant)
    {
        $form = $this->createDeleteForm($participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($participant);
            $em->flush();
        }

        return $this->redirectToRoute('participant_index');
    }

    /**
     * Creates a form to delete a participant entity.
     *
     * @param Participant $participant The participant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Participant $participant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('participant_delete', array('id' => $participant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
