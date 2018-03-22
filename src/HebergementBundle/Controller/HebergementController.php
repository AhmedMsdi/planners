<?php

namespace HebergementBundle\Controller;

use HebergementBundle\Entity\Hebergement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hebergement controller.
 *
 */
class HebergementController extends Controller
{
    /**
     * Lists all hebergement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->findAll();

        return $this->render('@Hebergement/hebergement/index.html.twig', array(
            'hebergements' => $hebergements,
        ));
    }
    public function indexhotelsAction()
    {
        return $this->render('@Hebergement/hebergement/hotels.html.twig');
    }

    public function indexmaisonsAction()
    {
        return $this->render('@Hebergement/hebergement/maisons.html.twig');
    }

    public function indexpensionsAction()
    {
        return $this->render('@Hebergement/hebergement/pensions.html.twig');
    }

    /**
     * Creates a new hebergement entity.
     *
     */
    public function newAction(Request $request)
    {
        $hebergement = new Hebergement();
        $form = $this->createForm('HebergementBundle\Form\HebergementType', $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hebergement);
            $em->flush();

            return $this->redirectToRoute('hebergement_show', array('id' => $hebergement->getId()));
        }

        return $this->render('@Hebergement/hebergement/new.html.twig', array(
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hebergement entity.
     *
     */
    public function showAction(Hebergement $hebergement)
    {
        $deleteForm = $this->createDeleteForm($hebergement);

        return $this->render('@Hebergement/hebergement/show.html.twig', array(
            'hebergement' => $hebergement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hebergement entity.
     *
     */
    public function editAction(Request $request, Hebergement $hebergement)
    {
        $deleteForm = $this->createDeleteForm($hebergement);
        $editForm = $this->createForm('HebergementBundle\Form\HebergementType', $hebergement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hebergement_edit', array('id' => $hebergement->getId()));
        }

        return $this->render('@Hebergement/hebergement/edit.html.twig', array(
            'hebergement' => $hebergement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hebergement entity.
     *
     */
    public function deleteAction(Request $request, Hebergement $hebergement)
    {
        $form = $this->createDeleteForm($hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hebergement);
            $em->flush();
        }

        return $this->redirectToRoute('hebergement_index');
    }

    /**
     * Creates a form to delete a hebergement entity.
     *
     * @param Hebergement $hebergement The hebergement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hebergement $hebergement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hebergement_delete', array('id' => $hebergement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
