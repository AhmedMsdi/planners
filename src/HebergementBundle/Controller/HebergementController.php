<?php

namespace HebergementBundle\Controller;

use HebergementBundle\Entity\Hebergement;
use HebergementBundle\Entity\Messagerie;
use PiBundle\Entity\User;
use PlanBundle\PlanBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
/**
 * Hebergement controller.
 *
 */
class HebergementController extends Controller
{


    public function mapAction(Request $request)
    {
        return $this->render("@Hebergement/hebergement/map.html.twig",['departid'=>$request->get("departid") , 'destinationid' => $request->get("destinationid")]);
    }


    public function editMAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $messageries = $em->getRepository('HebergementBundle:Hebergement')->find($id);
        $messageries->setDepart();
        $em->persist($messageries);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($messageries);
        return new JsonResponse($formatted);

    }


    /* Web service*/
    public function allAction()
    {
        $hebergements = $this->getDoctrine()->getManager()
            ->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->andWhere('e.enable like :val')
            ->setParameter('val',true)
            ->getQuery()
            ->execute();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergements);
        return new JsonResponse($formatted);
    }


    public function findAction($id)
    {
        $hebergement = $this->getDoctrine()->getManager()
            ->getRepository('HebergementBundle:Hebergement')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergement);
        return new JsonResponse($formatted);
    }

    public function WSnewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergement = new Hebergement();
        $hebergement->setTitre($request->get('titre'));
        $hebergement->setCategorie($request->get('categorie'));
        $hebergement->setPrix($request->get('prix'));
        $hebergement->setDescription($request->get('description'));
        $hebergement->setTel($request->get('tel'));
        $hebergement->setLieu($request->get('lieu'));
        $hebergement->setSiteWeb($request->get('siteWeb'));
        $hebergement->setPhoto($request->get('photo'));
        $hebergement->setEnable(0);
        $u =$em->getRepository("PiBundle:User")->find($request->get('idUser'));
        $hebergement->setIdUser($u);
        $hebergement->setDatecreation(new \DateTime());
        $hebergement->setX(35.829994611617);
        $hebergement->setY(10.629039578049);

        $em->persist($hebergement);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergement);
        return new JsonResponse($formatted);
    }


    public function WSdeleteAction(Hebergement $hebergement){
        $em=$this->getDoctrine()->getManager();

        $em->remove($hebergement);
        $em->flush();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($hebergement);
        return new JsonResponse($formatted);
    }
    /**
     * Lists all hebergement entities.
     *
     */
    public function indexAction(Request $request)
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

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hebergements, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())){

            $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
                ->where('e.enable like :val')
                ->setParameter('val',false)
                ->addORderBy('e.datecreation', 'DESC')
                ->getQuery()
                ->execute();
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $hebergements, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                6/*limit per page*/
            );
            return $this->render('@Hebergement/hebergementadmin/index.html.twig', array(
                'hebergements' => $pagination,
                'm'=>$m,
                'h'=>$h,
                'p'=>$p,
            ));
        }
        return $this->render('@Hebergement/hebergement/index.html.twig', array(
            'hebergements' => $pagination,
            'm'=>$m,
            'h'=>$h,
            'p'=>$p,
        ));
    }

    public function indexhotelsAction(Request $request)
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
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hebergements, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            $a = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('enable'=>false));

            return $this->render('@Hebergement/hebergementadmin/hotels.html.twig',array(
                'hebergements' => $pagination,
                'm'=>$m,
                'p'=>$p,
                'a'=>$a,));
        }
        return $this->render('@Hebergement/hebergement/hotels.html.twig',array(
            'hebergements' => $pagination,
            'm'=>$m,
            'p'=>$p,
            'a'=>$a,
        ));
    }

    public function indexmaisonsAction(Request $request)
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
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hebergements, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())){
            $a = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('enable'=>false));

            return $this->render('@Hebergement/hebergementadmin/maisons.html.twig',array(
                'hebergements' => $pagination,
                'a'=>$a,
                'h'=>$h,
                'p'=>$p,
            ));
        }
        return $this->render('@Hebergement/hebergement/maisons.html.twig',array(
            'hebergements' => $pagination,
            'a'=>$a,

            'h'=>$h,
            'p'=>$p,
        ));    }

    public function indexpensionsAction(Request $request)
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
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hebergements, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            $a = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('enable'=>false));

            return $this->render('@Hebergement/hebergementadmin/pensions.html.twig',array(
                'hebergements' => $pagination,
                'h'=>$h,
                'm'=>$m,
                'a'=>$a,

            ));
        }
        return $this->render('@Hebergement/hebergement/pensions.html.twig',array(
            'hebergements' => $pagination,
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
        }elseif (in_array('ROLE_CLIENT', $this->getUser()->getRoles())) {
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
        }
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
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
                $hebergement->setEnable(1);
                $em->persist($hebergement);
                $em->flush();

                return $this->redirectToRoute('hebergement_show', array('id' => $hebergement->getId()));
            }
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
    public function showAction(Request $request,Hebergement $hebergement)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user === 'anon.' ) {
            return $this->redirectToRoute('fos_user_security_login');
        }else
            $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($hebergement);
        $messagerie=new Messagerie();
        $form = $this->createForm('HebergementBundle\Form\MessagerieType', $messagerie);
        $form->handleRequest($request);

        $mes = $em->getRepository('HebergementBundle:Messagerie')->findOneBy(array('idheb'=>$hebergement->getId()));
        if ($mes!==null)
            $etat=$mes->getEtat();
        else $etat=0;
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            return $this->render('@Hebergement/hebergementadmin/show.html.twig', array(
                'hebergement' => $hebergement,
                'etat' => $etat,
                'formres'=>$form->createView(),
                'delete_form' => $deleteForm->createView(),

            ));
        }
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
        if ($user === 'anon.' or $user!==$hebergement->getIdUser() xor in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            $this->addFlash('danger','veuiller Connecter!!!');
            return $this->redirectToRoute('hebergement_show', array('id' => $hebergement->getId()));
        }elseif(in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) or $user===$hebergement->getIdUser()) {

            $deleteForm = $this->createDeleteForm($hebergement);
            $editForm = $this->createForm('HebergementBundle\Form\HebergementType', $hebergement);
            $editForm->handleRequest($request);
            $x=$hebergement->getPhoto();
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                if ($hebergement->getPhoto()=="")
                {
                    $hebergement->setPhoto($x);
                }
                /**
                 * @var UploadedFile $file
                 */
                $file = $hebergement->getPhoto();

                $file->move(
                    $this->getParameter('images_directory'), $file->getClientOriginalName());
                $hebergement->setPhoto($file->getClientOriginalName());

                $hebergement->setIdUser($user);
                $hebergement->setDatecreation(new \DateTime());
                $hebergement->setEnable(0);

                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('hebergement_show', array('id' => $hebergement->getId()));
            }
            if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
                return $this->render('@Hebergement/hebergementadmin/edit.html.twig', array(
                    'hebergement' => $hebergement,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
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
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            return $this->render('@Hebergement/hebergementadmin/rech.html.twig', array(
                'hebergements' => $hebergements,
                'm'=>$m,
                'h'=>$h,
                'p'=>$p,
            ));
        }
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
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            return $this->render('@Hebergement/hebergementadmin/rech.html.twig', array(
                'hebergements' => $hebergements,
                'm'=>$m,
                'h'=>$h,
                'p'=>$p,
            ));
        }
        return $this->render('@Hebergement/hebergement/rech.html.twig', array(
            'hebergements' => $hebergements,
            'm'=>$m,
            'h'=>$h,
            'p'=>$p,
        ));
    }

    public function espAction()
    {
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            return $this->render('@Hebergement/hebergementadmin/esp.html.twig');

        }

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
            if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
                return $this->render('@Hebergement/hebergementadmin/mesbonplan.html.twig', array(
                    'hebergements' => $hebergements,
                    'm'=>$m,
                    'h'=>$h,
                    'p'=>$p,
                ));

            }
            return $this->render('@Hebergement/hebergement/mesbonplan.html.twig', array(
                'hebergements' => $hebergements,
                'm'=>$m,
                'h'=>$h,
                'p'=>$p,
            ));
        }
    }
    public function pdfAction(Request $request,Hebergement $hebergement)
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


        $html= $this->render('@Hebergement/hebergement/pdf.html.twig', array(
            'hebergement' => $hebergement,
            'etat' => $etat,
            'mes'=>$mes,
            'formres'=>$form->createView(),
            'delete_form' => $deleteForm->createView(),

        ));


        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P','A4','en');
        $html2pdf->writeHTML($html);
        $html2pdf->Output('.pdf');


    }

    public function confAction(Request $request, Hebergement $hebergement)
    {

        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            $hebergement->setEnable(1);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hebergement_index');
        }
        else{
            return $this->redirectToRoute('hebergement_index');

        }
    }

    public function rechadminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $hebergements = $em->getRepository('HebergementBundle:Hebergement')->createQueryBuilder('e')
            ->where('e.lieu like :val')
            ->orWhere('e.categorie like :val')
            ->orWhere('e.description like :val')
            ->orWhere('e.siteWeb like :val')
            ->orWhere('e.titre like :val')
            ->addORderBy('e.datecreation', 'DESC')
            ->setParameter('val','%'.$_POST['recha'].'%')
            ->getQuery()
            ->execute();
        $h = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Hôtel",'enable'=>true));
        $m = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Maison_d'hôte",'enable'=>true));
        $p = $em->getRepository('HebergementBundle:Hebergement')->findBy(array('categorie'=>"Pensions",'enable'=>true));


        return $this->render('@Hebergement/hebergementadmin/rechadmin.html.twig', array(
            'hebergements' => $hebergements,
            'm'=>$m,
            'h'=>$h,
            'p'=>$p,
        ));

    }

    public function uploadImageAction(Request $request)
    {
        $imagename = $request->request->get('imagename');
        $Imagecode = $request->request->get('image');
        define('UPLOAD_DIR', 'C:/wamp64/www/planners/web/uploads/');
        $img = base64_decode($Imagecode);
        $uid = uniqid();
        $file = UPLOAD_DIR . $imagename . '.jpg';
        $success = file_put_contents($file, $img);
        if ($success) {
            return new JsonResponse(array('info' => $imagename . '.jpg'));
        } else {
            return new JsonResponse(array('info' => 'erreur'));
        }
    }



}
