<?php

namespace ReviewBundle\Controller;

use ReviewBundle\Entity\Signaisation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Signaisation controller.
 *
 */
class SignaisationController extends Controller
{
    /**
     * Lists all signaisation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $signaisations = $em->getRepository('ReviewBundle:Signaisation')->findAll();

        return $this->render('signaisation/index.html.twig', array(
            'signaisations' => $signaisations,
        ));
    }

    /**
     * Creates a new signaisation entity.
     *
     */
    public function newAction(Request $request)
    {
        $signaisation = new Signaisation();
        $form = $this->createForm('ReviewBundle\Form\SignaisationType', $signaisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($signaisation);
            $em->flush();

            return $this->redirectToRoute('signaisation_show', array('id' => $signaisation->getId()));
        }

        return $this->render('signaisation/new.html.twig', array(
            'signaisation' => $signaisation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a signaisation entity.
     *
     */
    public function showAction(Signaisation $signaisation)
    {
        $deleteForm = $this->createDeleteForm($signaisation);

        return $this->render('signaisation/show.html.twig', array(
            'signaisation' => $signaisation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing signaisation entity.
     *
     */
    public function editAction(Request $request, Signaisation $signaisation)
    {
        $deleteForm = $this->createDeleteForm($signaisation);
        $editForm = $this->createForm('ReviewBundle\Form\SignaisationType', $signaisation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('signaisation_edit', array('id' => $signaisation->getId()));
        }

        return $this->render('signaisation/edit.html.twig', array(
            'signaisation' => $signaisation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a signaisation entity.
     *
     */
    public function deleteAction(Request $request, Signaisation $signaisation)
    {
        $form = $this->createDeleteForm($signaisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($signaisation);
            $em->flush();
        }

        return $this->redirectToRoute('signaisation_index');
    }

    /**
     * Creates a form to delete a signaisation entity.
     *
     * @param Signaisation $signaisation The signaisation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Signaisation $signaisation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('signaisation_delete', array('id' => $signaisation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
