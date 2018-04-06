<?php

namespace BackOfficeBundle\Controller;

use PlanBundle\Entity\Plan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlanBackOffController extends Controller
{
    public function indexAction()
    {
        return $this->render('@BackOffice/template/index.html.twig');
    }
    public function layoutAction()
    {
        return $this->render('@BackOffice/template/layout.html.twig');
    }
    public function widgetAction()
    {
        return $this->render('@BackOffice/template/widget.html.twig');
    }

    public function chartAction()
    {
        return $this->render('@BackOffice/template/chart.html.twig');
    }
    public function tableAction()
    {
        return $this->render('@BackOffice/template/table.html.twig');
    }
    public function formAction()
    {
        return $this->render('@BackOffice/template/form.html.twig');
    }
    public function panelAction()
    {
        return $this->render('@BackOffice/template/panel.html.twig');
    }
    public function iconAction()
    {
        return $this->render('@BackOffice/template/icon.html.twig');
    }


    public function AllPlansBackAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->findAll();

        return $this->render('@BackOffice/plan/TableauAllPlans.html.twig', array(
            'plans' => $plans,
        ));
    }


    public function ValiderPlanAction($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $plans = $em->getRepository('PlanBundle:Plan')->find($idP);
        $plans->setEtat(1);
        $em->flush();

        return $this->redirectToRoute('plan_indextableau', array(
            'plans' => $plans
        ));


    }
    public function NonValidePlanAction($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $plans = $em->getRepository('PlanBundle:Plan')->find($idP);
        $plans->setEtat(0);
        $em->flush();

        return $this->redirectToRoute('plan_indextableau', array(
            'plans' => $plans
        ));
    }

        public function AjouterPlanBackAction(Request $request)
    {
        $plan= new Plan();
        if($request->isMethod("post")) {

            $plan->setLibelle($request->get("libelle"));
            $plan->setAdresse($request->get("Adresse"));
            $plan->setDescription($request->get("description"));

            $plan->setVille($request->get("ville"));

            $plan->setImage($request->get("image"));
            $plan->setAvis(2);
            $plan->setEmail($request->get("email"));

            $plan->setPrix($request->get("prix"));
            $plan->setLongitude($request->get("longitude"));
            $plan->setLatitude($request->get("latitude"));

            $plan->setNote(3);

            $plan->setEtat(1);
            $plan->setEtatnotif('0');

            $EM = $this->getDoctrine()->getManager();

            $EM->persist($plan);

            $EM->flush();

                    return $this->redirectToRoute('plan_indextableau');
                }


        return $this->render('@BackOffice/plan/new_plan_Back.html.twig'
        );

    }



}
