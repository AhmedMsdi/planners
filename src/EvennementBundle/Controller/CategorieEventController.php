<?php

namespace EvennementBundle\Controller;

use EvennementBundle\Entity\CategorieEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Categorieevent controller.
 *
 * @Route("categorieevent")
 */
class CategorieEventController extends Controller
{
    /**
     * Lists all categorieEvent entities.
     *
     * @Route("/", name="categorieevent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieEvents = $em->getRepository('EvennementBundle:CategorieEvent')->findAll();

        return $this->render('EvennementBundle:categorieevent:index.html.twig', array(
            'categorieEvents' => $categorieEvents,
        ));
    }

    /**
     * Creates a new categorieEvent entity.
     *
     * @Route("/new", name="categorieevent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorieEvent = new Categorieevent();
        $form = $this->createForm('EvennementBundle\Form\CategorieEventType', $categorieEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieEvent);
            $em->flush();

            return $this->redirectToRoute('categorieevent_show', array('id' => $categorieEvent->getId()));
        }

        return $this->render('EvennementBundle:categorieevent:new.html.twig', array(
            'categorieEvent' => $categorieEvent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieEvent entity.
     *
     * @Route("/{id}", name="categorieevent_show")
     * @Method("GET")
     */
    public function showAction(CategorieEvent $categorieEvent)
    {
        $deleteForm = $this->createDeleteForm($categorieEvent);

        return $this->render('EvennementBundle:categorieevent:show.html.twig', array(
            'categorieEvent' => $categorieEvent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieEvent entity.
     *
     * @Route("/{id}/edit", name="categorieevent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CategorieEvent $categorieEvent)
    {
        $deleteForm = $this->createDeleteForm($categorieEvent);
        $editForm = $this->createForm('EvennementBundle\Form\CategorieEventType', $categorieEvent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorieevent_index');
        }

        return $this->render('EvennementBundle:categorieevent:edit.html.twig', array(
            'categorieEvent' => $categorieEvent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieEvent entity.
     *
     * @Route("/{id}", name="categorieevent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategorieEvent $categorieEvent)
    {
        $form = $this->createDeleteForm($categorieEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieEvent);
            $em->flush();
        }

        return $this->redirectToRoute('categorieevent_index');
    }

    /**
     * Creates a form to delete a categorieEvent entity.
     *
     * @param CategorieEvent $categorieEvent The categorieEvent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategorieEvent $categorieEvent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorieevent_delete', array('id' => $categorieEvent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
