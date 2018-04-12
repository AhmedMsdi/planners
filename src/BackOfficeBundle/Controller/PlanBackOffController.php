<?php

namespace BackOfficeBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\GaugeChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use PiBundle\Entity\User;
use PlanBundle\Entity\Plan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlanBackOffController extends Controller
{
    public function indexAction()
    {
        return $this->render('@BackOffice/template/index.html.twig');
    }
    public function gestionAction()
    {
        return $this->render('@BackOffice/plan/gestionplans.html.twig');
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

        $plans = $em->getRepository('PlanBundle:Plan')->findBy(['etat'=>0]);

        return $this->render('@BackOffice/plan/TableauAllPlans2.html.twig', array(
            'plans' => $plans,
        ));
    }


    public function ValiderPlanAction($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $plans = $em->getRepository('PlanBundle:Plan')->find($idP);
        $idu=$plans->getUser();
        $users = $em->getRepository('PiBundle:User')->find($idu);
        $plans->setEtat(1);
        $ptfid=$users->getPointFidelite();
        $ptfidf=$ptfid+5;
        $users->setPointFidelite($ptfidf);

       // $em ->persist($users);
        $em->flush();
/*
        $emm = $this->getDoctrine()->getManager();
        $user = $emm->getRepository('PiBundle:User')->find(17);
        $user->setPointFidelite(5);
        $emm->flush();
*/
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


    public  function AllPlansAction(){
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->findAll();

        return $this->render('@BackOffice/plan/ListePlans.html.twig', array(
            'plans' => $plans,
        ));
    }

    public function StatiqtiquesAllPlansAction() {
        $em = $this->getDoctrine()->getManager();
        $plans = $em->getRepository('PlanBundle:Plan')->StatGlobaleArrayAction();

        $pieChart = new ComboChart();

        $data= array();
        $stat=['classe', 'Plan'];
        array_push($data,$stat);

        foreach($plans as $plan) {
            $stat=array();
            $nb=$plan['nbrplan'];
            $lib=$plan['libsrc'];
            $stat = [$lib,(int)$nb];
            array_push($data, $stat);
        }


        /*
        $stat=['classe', 'nbEtudiant'];
        $nb=0;
        array_push($data,$stat);
        foreach($plans as $plan) {
            $stat=array();
            array_push($stat,$plan->getLibelle(),(($plan->getNote()) *100)/$totalPlan);
            $nb=($plan->getNote() *100)/$totalPlan;
            $stat=[$plan->getLibelle(),$nb];
            array_push($data,$stat);
        }
*/
        $pieChart->getData()->setArrayToDataTable(
            $data);

        $pieChart->getOptions()->setHeight(550);
        $pieChart->getOptions()->setWidth(1000);

        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(18);

        return $this->render('@BackOffice/plan/StatistiqueGlobale.html.twig', array('piechart' => $pieChart));
    }
}
