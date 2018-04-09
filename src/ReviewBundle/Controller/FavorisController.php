<?php

namespace ReviewBundle\Controller;

use ReviewBundle\Entity\Favoris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Favori controller.
 *
 * @Route("favoris")
 */
class FavorisController extends Controller
{
    /**
     * Lists all favori entities.
     *
     * @Route("/", name="favoris_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $favoris = $em->getRepository('ReviewBundle:Favoris')->findAll();

        return $this->render('favoris/index.html.twig', array(
            'favoris' => $favoris,
        ));
    }

    /**
     * Creates a new favori entity.
     *
     * @Route("/new", name="favoris_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $favori = new Favori();
        $form = $this->createForm('ReviewBundle\Form\FavorisType', $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($favori);
            $em->flush();

            return $this->redirectToRoute('favoris_show', array('id' => $favori->getId()));
        }

        return $this->render('favoris/new.html.twig', array(
            'favori' => $favori,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a favori entity.
     *
     * @Route("/{id}", name="favoris_show")
     * @Method("GET")
     */
    public function showAction(Favoris $favori)
    {
        $deleteForm = $this->createDeleteForm($favori);

        return $this->render('favoris/show.html.twig', array(
            'favori' => $favori,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing favori entity.
     *
     * @Route("/{id}/edit", name="favoris_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Favoris $favori)
    {
        $deleteForm = $this->createDeleteForm($favori);
        $editForm = $this->createForm('ReviewBundle\Form\FavorisType', $favori);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('favoris_edit', array('id' => $favori->getId()));
        }

        return $this->render('favoris/edit.html.twig', array(
            'favori' => $favori,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a favori entity.
     *
     * @Route("/{id}", name="favoris_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Favoris $favori)
    {
        $form = $this->createDeleteForm($favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($favori);
            $em->flush();
        }

        return $this->redirectToRoute('favoris_index');
    }

    /**
     * Creates a form to delete a favori entity.
     *
     * @param Favoris $favori The favori entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Favoris $favori)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('favoris_delete', array('id' => $favori->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
