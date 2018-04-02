<?php

namespace EvennementBundle\Controller;

use EvennementBundle\Entity\Evennement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Evennement controller.
 *
 * @Route("evennement")
 */
class EvennementController extends Controller
{
    /**
     * Lists all evennement entities.
     *
     * @Route("/", name="evennement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evennements = $em->getRepository('EvennementBundle:Evennement')->findAll();

        return $this->render('EvennementBundle:evennement:index.html.twig', array(
            'evennements' => $evennements,
        ));
    }

    /**
     * Creates a new evennement entity.
     *
     * @Route("/new", name="evennement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evennement = new Evennement();
        $form = $this->createForm('EvennementBundle\Form\EvennementType', $evennement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evennement);
            $em->flush();

            return $this->redirectToRoute('evennement_show', array('id' => $evennement->getId()));
        }

        return $this->render('EvennementBundle:evennement:new.html.twig', array(
            'evennement' => $evennement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a evennement entity.
     *
     * @Route("/{id}", name="evennement_show")
     * @Method("GET")
     */
    public function showAction(Evennement $evennement)
    {
        $deleteForm = $this->createDeleteForm($evennement);

        return $this->render('EvennementBundle:evennement:show.html.twig', array(
            'evennement' => $evennement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evennement entity.
     *
     * @Route("/{id}/edit", name="evennement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Evennement $evennement)
    {
        $deleteForm = $this->createDeleteForm($evennement);
        $editForm = $this->createForm('EvennementBundle\Form\EvennementType', $evennement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evennement_edit', array('id' => $evennement->getId()));
        }

        return $this->render('EvennementBundle:evennement:edit.html.twig', array(
            'evennement' => $evennement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evennement entity.
     *
     * @Route("/{id}", name="evennement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Evennement $evennement)
    {
        $form = $this->createDeleteForm($evennement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evennement);
            $em->flush();
        }

        return $this->redirectToRoute('evennement_index');
    }

    /**
     * Creates a form to delete a evennement entity.
     *
     * @param Evennement $evennement The evennement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evennement $evennement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evennement_delete', array('id' => $evennement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
