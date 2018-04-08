<?php

namespace EvennementBundle\Controller;

use EvennementBundle\Entity\Evennement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

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

        return $this->render('EvennementBundle:evennement:admin/index.html.twig', array(
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

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($evennement);
            $em->flush();

            $file = $evennement->getImage();
            $fileName = $evennement->getId() . '_' . $this->generateUniqueFileName() . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('imageEvent'), $fileName
            );
            $evennement->setImage($fileName);
            $em->persist($evennement);
            $em->flush();
            return $this->redirectToRoute('evennement_show', array('id' => $evennement->getId()));
        }

        return $this->render('EvennementBundle:evennement:admin/new.html.twig', array(
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

        return $this->render('EvennementBundle:evennement:admin/show.html.twig', array(
            'evennement' => $evennement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a evennement entity.
     *
     * @Route("/{id}", name="valider_event")
     * @Method("GET")
     */
    public function ValiderEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('EvennementBundle:Evennement')->find($id);
        $events->setEtat(1);
        return
$this->render('@Evennement/evennement/admin/index.html.twig') ;

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
        $editForm = $this->createForm('EvennementBundle\Form\EvennementEditType', $evennement);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /* echo "<pre>".print_r($request->request->all(),1)."</pre>";
                         echo "<pre>".print_r($request->files->all(),1)."</pre>";
                         exit();*/
            $em = $this->getDoctrine()->getManager();
            $file = $evennement->getEditImage();
            if (!empty($file)) {
                $ds = DIRECTORY_SEPARATOR;


                $fileName = $evennement->getId() . '_' . $this->generateUniqueFileName() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('imageEvent'), $fileName
                );

                $photoName = $this->getParameter('imageEvent') . $ds . $evennement->getImage();
                if (file_exists($photoName))
                    unlink($photoName);
                $evennement->setImage($fileName);
            }
            $em->persist($evennement);
            $em->flush();
            return $this->redirectToRoute('evennement_edit', array('id' => $evennement->getId()));
        }

        return $this->render('EvennementBundle:evennement:admin/edit.html.twig', array(
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
            $ds = DIRECTORY_SEPARATOR;
            $photoName = $this->getParameter('imageEvent') . $ds . $evennement->getImage();
            if (file_exists($photoName))
                unlink($photoName);
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
            ->getForm();
    }

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
