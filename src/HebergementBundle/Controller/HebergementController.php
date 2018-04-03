<?php

namespace HebergementBundle\Controller;

use HebergementBundle\Entity\Hebergement;
use HebergementBundle\Entity\Messagerie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $h = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Hôtel",'enable'=>true));
        $m = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Maison_d'hôte",'enable'=>true));
        $p = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Pensions",'enable'=>true));

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.enable like :val')
            ->setParameter('val',true)
            ->addORderBy('e.datecreation', 'DESC')
            ->getQuery()
            ->execute();

        return $this->render('@Hebergement/hebergement/index.html.twig', array(
            'hebergements' => $hebergements,
            'm'=>$m,
            'h'=>$h,
            'p'=>$p,
        ));
    }

    public function indexhotelsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $m = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Maison_d'hôte",'enable'=>true));
        $p = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Pensions",'enable'=>true));
        $a = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('enable'=>true));
        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.categorie like :h')
            ->andWhere('e.enable like :val')
            ->setParameter('val',true)
            ->setParameter('h','Hôtel')
            ->addORderBy('e.datecreation', 'DESC')
            ->getQuery()
            ->execute();

        return $this->render('@Hebergement/hebergement/hotels.html.twig',array(
        'hebergements' => $hebergements,
            'm'=>$m,
            'p'=>$p,
            'a'=>$a,
    ));
    }

    public function indexmaisonsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $h = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Hôtel",'enable'=>true));
        $p = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Pensions",'enable'=>true));
        $a = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('enable'=>true));

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.categorie like :h')
            ->andWhere('e.enable like :val')
            ->setParameter('val',true)
            ->setParameter('h','Maison_d\'hôte')
            ->addORderBy('e.datecreation', 'DESC')
            ->getQuery()
            ->execute();

        return $this->render('@Hebergement/hebergement/maisons.html.twig',array(
            'hebergements' => $hebergements,
            'a'=>$a,

            'h'=>$h,
            'p'=>$p,
        ));    }

    public function indexpensionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $h = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Hôtel",'enable'=>true));
        $m = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Maison_d'hôte",'enable'=>true));
        $a = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('enable'=>true));

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.categorie like :h')
            ->andWhere('e.enable like :val')
            ->setParameter('val',true)
            ->setParameter('h','Pensions')
            ->addORderBy('e.datecreation', 'DESC')
            ->getQuery()
            ->execute();

        return $this->render('@Hebergement/hebergement/pensions.html.twig',array(
            'hebergements' => $hebergements,
            'h'=>$h,
            'm'=>$m,
            'a'=>$a,

        )); }

    /**
     * Creates a new hebergement entity.
     *
     */
    public function newAction(Request $request)
    {

        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user === 'anon.' ) {
            $this->addFlash('danger','veuiller Connecter!!!');
             return $this->redirectToRoute('pi_homepage');
        }else{
            $hebergement = new Hebergement();
        $form = $this->createForm('HebergementBundle\Form\HebergementType', $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $hebergement->getPhoto();

            $file->move(
                $this->getParameter('images_directory'), $file->getClientOriginalName());
            $hebergement->setPhoto($file->getClientOriginalName());
            $hebergement->setDatecreation(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $hebergement->setIdUser($user);
            $hebergement->setEnable(0);
            $em->persist($hebergement);
            $em->flush();

            return $this->redirectToRoute('hebergement_show', array('id' => $hebergement->getId()));
        }

        return $this->render('@Hebergement/hebergement/new.html.twig', array(
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ));
    }}

    /**
     * Finds and displays a hebergement entity.
     *
     */
    public function showAction(Request $request,Hebergement $hebergement)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($hebergement);
        $messagerie=new Messagerie();
        $form = $this->createForm('HebergementBundle\Form\MessagerieType', $messagerie);
        $form->handleRequest($request);

        $mes = $em->getRepository('HebergementBundle:Messagerie')->findOneBy(array('idheb'=>$hebergement->getId()));
        if ($mes!==null)
        $etat=$mes->getEtat();
        else $etat=0;
        return $this->render('@Hebergement/hebergement/show.html.twig', array(
            'hebergement' => $hebergement,
            'etat' => $etat,
            'formres'=>$form->createView(),
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to edit an existing hebergement entity.
     *
     */
    public function editAction(Request $request, Hebergement $hebergement)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user === 'anon.' or $user!==$hebergement->getIdUser()) {
            $this->addFlash('danger','veuiller Connecter!!!');
            return $this->redirectToRoute('hebergement_show', array('id' => $hebergement->getId()));
        }else {

            $deleteForm = $this->createDeleteForm($hebergement);
            $editForm = $this->createForm('HebergementBundle\Form\HebergementType', $hebergement);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                /**
                 * @var UploadedFile $file
                 */
                $file = $hebergement->getPhoto();

                $file->move(
                    $this->getParameter('images_directory'), $file->getClientOriginalName());
                $hebergement->setPhoto($file->getClientOriginalName());

                $hebergement->setIdUser($user);
                $hebergement->setDatecreation(new \DateTime());

                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('hebergement_show', array('id' => $hebergement->getId()));
            }

            return $this->render('@Hebergement/hebergement/edit.html.twig', array(
                'hebergement' => $hebergement,
                'form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }    }

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

    public function rechAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $h = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Hôtel"));
        $m = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Maison_d'hôte"));
        $p = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Pensions"));

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.lieu like :val')

            ->addORderBy('e.datecreation', 'DESC')
            ->setParameter('val','%'.$name.'%')
            ->getQuery()
            ->execute();

        return $this->render('@Hebergement/hebergement/rech.html.twig', array(
            'hebergements' => $hebergements,
            'm'=>$m,
            'h'=>$h,
            'p'=>$p,
        ));
    }

    public function rech2Action()
    {

        $em = $this->getDoctrine()->getManager();
        $h = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Hôtel"));
        $m = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Maison_d'hôte"));
        $p = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Pensions"));

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.prix <=   :val')
            ->addORderBy('e.datecreation', 'DESC')
            ->setParameter('val',$_GET['maxprix'])
            ->getQuery()
            ->execute();

        return $this->render('@Hebergement/hebergement/rech.html.twig', array(
            'hebergements' => $hebergements,
            'm'=>$m,
            'h'=>$h,
            'p'=>$p,
        ));
    }

    public function espAction()
    {


        return $this->render('@Hebergement/hebergement/esp.html.twig');
    }

    public function mesbonplanAction()
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user === 'anon.' ) {
            return $this->redirectToRoute('pi_homepage');
        }else{
        $em = $this->getDoctrine()->getManager();
        $h = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Hôtel",'idUser'=>$user));
        $m = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Maison_d'hôte",'idUser'=>$user));
        $p = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Pensions",'idUser'=>$user));

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.idUser =:val')
            ->setParameter('val',$user)
            ->addORderBy('e.datecreation', 'DESC')
            ->getQuery()
            ->execute();

        return $this->render('@Hebergement/hebergement/mesbonplan.html.twig', array(
            'hebergements' => $hebergements,
            'm'=>$m,
            'h'=>$h,
            'p'=>$p,
        ));
        }
    }


}
