<?php

namespace PlanBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use PlanBundle\Entity\Plan;
use PlanBundle\Entity\Rating;
use PlanBundle\Form\ModifierAjoutType;
use PlanBundle\Form\PlanType;
use blackknight467\StarRatingBundle\Form\RatingType;
use Proxies\__CG__\PlanBundle\Entity\SousCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $rating = $em->getRepository('PlanBundle:Rating')->AVGRating();
        return $this->render('@Plan/plan/single-news.html.twig', array(
            'plans' => $plans,
            'rating' => $rating
        ));
    }


    public function FilterDivertissementAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->DivertisementsAction();
        $rating = $em->getRepository('PlanBundle:Rating')->AVGRating();

        return $this->render('@Plan/Default/DivertissementSousCatAffichage.html.twig', array(
            'plans' => $plans,
            'rating' => $rating
        ));
    }


    public function FilterGastronomieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rating = $em->getRepository('PlanBundle:Rating')->findAll();
        $rating = $em->getRepository('PlanBundle:Rating')->AVGRating();
        $plans = $em->getRepository('PlanBundle:Plan')->GastronomieAction();
        //$plans = $em->getRepository('PlanBundle:Plan')->findAll();

        //$plansgas=array() ;
        //foreach ($plans as $plan){
        //    if($plan->ge)
        //}

        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,
            'rating' => $rating
        ));
    }

    public function FilterBEAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->BienEAction();
        $rating = $em->getRepository('PlanBundle:Rating')->AVGRating();

        return $this->render('@Plan/Default/BienEtreSousCatAffichage.html.twig', array(
            'plans' => $plans,
            'rating' => $rating
        ));
    }

    /**
     * tableau all plan entities .
     *
     */

    public function indexAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->findAll();

        return $this->render('@Plan/plan/indexAllPlans.html.twig', array(
            'plans' => $plans,
        ));
    }

    public function indexAllMethode2Action(Request $request)
    {
        $plan = new Plan();
        $form = $this->createForm('PlanBundle\Form\PlanType', $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plan->SetEtat(0);
            $plan->setEtatnotif(0);

            $em = $this->getDoctrine()->getManager();

            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('plan_show', array('idP' => $plan->getIdp()));
        }

        return $this->render('@Plan/plan/indexAllPlansMethode2.html.twig', array(
            'plan' => $plan,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new plan entity.
     *
     */
    public function newAction(Request $request)
    {
        $plan = new Plan();
        $form = $this->createForm('PlanBundle\Form\PlanType', $plan);
        $form->handleRequest($request);
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $plan->getImage();
            $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();
            $image->move($this->getParameter('brochures_directory'), $imageName);
            $plan->setImage($imageName);

            $plan->SetEtat(0);
            $plan->setEtatnotif(0);
            $em = $this->getDoctrine()->getManager();

            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('plan_show', array('idP' => $plan->getIdp()));
        }
        $categories = $em->getRepository('PlanBundle:Categorie')->findAll();
        return $this->render('@BackOffice/template/new_plan_Back.html.twig', array(
            'plan' => $plan,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    public function newPlanDesignAction(Request $request)
    {
        $plan = new Plan();
        $user = $this->getUser();

        $form = $this->createForm('PlanBundle\Form\PlanType', $plan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $plan->getImage();
            $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();
            $image->move($this->getParameter('brochures_directory'), $imageName);
            $plan->setImage($imageName);

            $plan->SetEtat(0);
            $plan->setEtatnotif(0);
            $em = $this->getDoctrine()->getManager();
            $plan->setUser($user);

            $em->persist($plan);
            $em->flush();

        }
//        return $this->render('@Plan/plan/NewPlanDesign.html.twig', array(
//            'plan' => $plan,
//            'form' => $form->createView(),
//        ));

        return $this->render('@Plan/plan/single-news.html.twig', array(
            'plan' => $plan,
            'form' => $form->createView(),
        ));
    }


    public function showFrontComAction(Request $request, $id)
    {
        $em = $this->get('doctrine')->getManager();
        $plan = $em->getRepository('PlanBundle:Plan')->find($id);
        return $this->render('@Plan/plan/PlanMaps.html.twig', array("plan" => $plan));


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
        $editForm = $this->createForm('PlanBundle\Form\ModifierAjoutType', $plan);
        $editForm->handleRequest($request);
        $plan->setEtat(0);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            //return $this->redirectToRoute('plan_indextableau', array('idP' => $plan->getIdp()));
        }

        return $this->render('@Plan/plan/edit.html.twig', array(
            'plan' => $plan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function ModifPhotoAction(Request $request, $idP)
    {
        $em = $this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("PlanBundle:Plan")->find($idP);
        $etablissement->setImage
        (new File($this->getParameter('brochures_directory') . '/' . $etablissement->getImage()));
        $form = $this->createForm(ModifierAjoutType ::class, $etablissement);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            /** @var UploadedFile $image */
            $image = $etablissement->getImage();
            $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();
            $image->move($this->getParameter('brochures_directory'), $imageName);
            $etablissement->setImage($imageName);
            $em->persist($etablissement);
            $em->flush();
            return $this->redirectToRoute('plan_indextableau', array('idP' => $etablissement->getIdp()));

        }
        return $this->render('@Plan/plan/edit.html.twig',
            array('edit_form' => $form->createView(), 'nom' => $etablissement->getLibelle()));
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

        return $this->redirectToRoute('plan_indextableau');
    }


    public function delete2Action($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository("PlanBundle:Plan")->find($idP);
        $em->remove($modele);
        $em->flush();
        return $this->redirectToRoute('plan_indextableau');
    }



    private function createDeleteForm(Plan $plan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plan_delete', array('idP' => $plan->getIdp())))
            ->setMethod('DELETE')
            ->getForm();
    }



    public function DivertissementFilterHorizontalePageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->DivertisementsAction();

        return $this->render('PlanBundle:Default:Divertissement-horizontal.html.twig', array(
            'plans' => $plans,
        ));

    }

    public function GastronomieFilterHorizontalePageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->GastronomieAction();
        return $this->render('PlanBundle:Default:Gastronomie-horizontal.html.twig', array(
            'plans' => $plans,
        ));
    }

    public function BEFilterHorizontalePageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->BienEAction();
        return $this->render('PlanBundle:Default:BienEtre-horizontal.html.twig', array(
            'plans' => $plans,
        ));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function DetailsAction(Request $request, $idP)
    {
        $em = $this->getDoctrine()->getManager();
        $m = $this->getDoctrine()->getManager();
        $plan = $em->getRepository('PlanBundle:Plan')->find($idP);
        $idsc = $plan->getIdSc();
        $sc = new SousCategorie();
        $sc = $idsc;
        $idscss = $sc->getIdSc();
        $message = $idscss;

        $plan->setAvis("http://www.localhost/planners/web/app_dev.php/plan/detailG/$idP");
        if ($idscss >= 5 && $idscss <= 12)
            $message = '  La gastronomie est l\'art d\'utiliser la nourriture pour créer le bonheur';

        else if ($idscss >= 1 && $idscss <= 4)
            $message = ' Être bien dans sa peau, c\'est s\'accepter, s\'aimer, offrir son visage au souffle du vent.';

        else if ($idscss >= 12 && $idscss <= 17)
            $message = ' Le divertissement est le meilleur régime contre le poids de l\'existence....';


        $mark = $em->getRepository('PlanBundle:Plan')->find($idP);
        $rating = $m->getRepository('PlanBundle:Rating')->AVGRating();
        $rating=new Rating();


        $form=$this->createFormBuilder($rating)
            ->add('rating', RatingType::class, [
                'label' => 'Rating'
            ])
            ->add('valider',SubmitType::class, array(
                'attr' => array(

                    'class'=>'btn btn-xs btn-primary'
                )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rating->setPlan($mark->getIdP());
            $em->persist($rating);
            $em->flush();
        }








        return $this->render('@Plan/plan/details2.html.twig', array(
            'plan' => $plan, 'msg' => $message,
            'mark' => $mark,'form'=> $form->createView(),'rating'=>$rating
        ));

    }

    public function GelaterieFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(12);
        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,

        ));
    }
    public function Fast_FoodFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(11);
        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function LoungeFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(7);
        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function PA_BAFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(10);
        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function CaffeFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(6);
        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function RestoFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(8);
        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function centreCommFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(1);
        return $this->render('@Plan/Default/DivertissementSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function ParcFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(2);
        return $this->render('@Plan/Default/DivertissementSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function MuseFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(3);
        return $this->render('@Plan/Default/DivertissementSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function EquitationnFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(4);
        return $this->render('@Plan/Default/DivertissementSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function GolfFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(5);
        return $this->render('@Plan/Default/DivertissementSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function Salon_CoiffFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(13);
        return $this->render('@Plan/Default/BienEtreSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));
    }
    public function Salle_SportFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(14);
        return $this->render('@Plan/Default/BienEtreSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));}
        public function SpatFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(15);
        return $this->render('@Plan/Default/BienEtreSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));}
        public function Make_upFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(16);
        return $this->render('@Plan/Default/BienEtreSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));}
        public function piercing_tatoosFilterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->FilterAction(17);
        return $this->render('@Plan/Default/BienEtreSousCatAffichage.html.twig', array(
            'plans' => $plans,
        ));}


    public function RechercheFilterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //  if ($request->isMethod('POST'))
        //  {
        $nom = $request->get('abc');
        $Reg = $request->get('Reg');
        $plans = $em->getRepository('PlanBundle:Plan')->FindAction($nom,$Reg);
        return $this->render('@Plan/Default/GastronomieFilter.html.twig', array(
            'plans' => $plans,
        ));


    }

   /* public function StatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('PlanBundle:Plan')->findAll();
        return $this->render('@Plan/plan/stat.html.twig', array(
            'plans' => $plans,
        ));
    }*/


   public function Stat2Action()
    {        $em = $this->getDoctrine()->getManager();
        $plans = $em->getRepository('PlanBundle:Plan')->StatArrayAction();

        $pieChart = new PieChart();

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

        $pieChart->getOptions()->setTitle('Les satistiques par categorie');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Plan/plan/stat.html.twig', array('piechart' => $pieChart));
    }



}
