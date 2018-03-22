<?php

namespace PlanBundle\Controller;

use PlanBundle\Entity\Plan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Plan controller.
 *
 */
class PlanController extends Controller
{
    /**
     * Lists all plan entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->findAll();

        return $this->render('@Plan/plan/index.html.twig', array(
            'plans' => $plans,
        ));
    }

    /**_(
     * Creates a new plan entity.
     *
     */
    public function newAction(Request $request)
    {
        $plan = new Plan();
        $form = $this->createForm('PlanBundle\Form\PlanType', $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('plan_show', array('idP' => $plan->getIdp()));
        }

        return $this->render('@Plan/plan/new.html.twig', array(
            'plan' => $plan,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a plan entity.
     *
     */
    public function showAction(Plan $plan)
    {
        $deleteForm = $this->createDeleteForm($plan);

        return $this->render('@Plan/plan/show.html.twig', array(
            'plan' => $plan,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plan entity.
     *
     */
    public function editAction(Request $request, Plan $plan)
    {
        $deleteForm = $this->createDeleteForm($plan);
        $editForm = $this->createForm('PlanBundle\Form\PlanType', $plan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plan_edit', array('idP' => $plan->getIdp()));
        }

        return $this->render('@Plan/plan/edit.html.twig', array(
            'plan' => $plan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a plan entity.
     *
     */
    public function deleteAction(Request $request, Plan $plan)
    {
        $form = $this->createDeleteForm($plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plan);
            $em->flush();
        }

        return $this->redirectToRoute('plan_index');
    }

    /**
     * Creates a form to delete a plan entity.
     *
     * @param Plan $plan The plan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plan $plan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plan_delete', array('idP' => $plan->getIdp())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    public function GastronomieFilterAction()
    {
        return $this->render('PlanBundle:Default:GastronomieFilter.html.twig');
    }


    public function DivertissementFilterPageAction()
    {
        return $this->render('PlanBundle:Default:DivertissementSousCatAffichage.html.twig');
    }

    public function BienEtretFilterPageAction()
    {
        return $this->render('PlanBundle:Default:BienEtreSousCatAffichage.html.twig');
    }

    public function DivertissementFilterHorizontalePageAction()
    {
        return $this->render('PlanBundle:Default:Divertissement-horizontal.html.twig');
    }

    public function GastronomieFilterHorizontalePageAction()
    {
        return $this->render('PlanBundle:Default:Gastronomie-horizontal.html.twig');
    }

    public function BEFilterHorizontalePageAction()
    {
        return $this->render('PlanBundle:Default:BienEtre-horizontal.html.twig');
    }

}
