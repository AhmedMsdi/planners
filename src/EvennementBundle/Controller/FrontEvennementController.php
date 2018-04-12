<?php

namespace EvennementBundle\Controller;

use EvennementBundle\Entity\Evennement;
use EvennementBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Evennement controller.
 *
 * @Route("/")
 */
class FrontEvennementController extends Controller
{
    /**
     * Lists all evennement entities.
     *
     * @Route("/mesevennement", name="evennement_list")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evennements = $em->getRepository('EvennementBundle:Evennement')->findBy(['User'=>$this->getUser()->getId()]);

        return $this->render('EvennementBundle:evennement:front/index.html.twig', array(
            'evennements' => $evennements,
        ));
    }
    /**
     * Lists all evennement entities.
     *
     * @Route("/mesevennementList", name="MesEvennement_list")
     * @Method("GET")
     */
    public function MonIndexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evennements = $em->getRepository('EvennementBundle:Evennement')->findBy(['User'=>$this->getUser()->getId()]);

        return $this->render('EvennementBundle:evennement:front/MesEvent.html.twig', array(
            'evennements' => $evennements,
        ));

    }



    /**
     * Lists all evennement entities.
     *
     * @Route("/menuevent", name="menu_event")
     * @Method("GET")
     */
    public function MenuEventAction()
    {
        $em = $this->getDoctrine()->getManager();
        $list_categ=$em->getRepository('EvennementBundle:CategorieEvent')->findAll();
        return $this->render('EvennementBundle:evennement:front/menuEvent.html.twig', array(
            'list_categ' => $list_categ,
        ));
    }

    /**
     * Lists all evennement entities.
     *
     * @Route("/listeevennement", name="evennement_listall")
     * @Method("GET")
     */
    public function listAllEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cond=[];
        $id_categ=0;
    if(!empty($request->query->get('categ'))) {
        $id_categ=$request->query->get('categ');
        $cond['CatEvent']=$request->query->get('categ');
    }
        $evennements = $em->getRepository('EvennementBundle:Evennement')->MyFindAll($cond);

        $list_categ=$em->getRepository('EvennementBundle:CategorieEvent')->findAll();
        $tab_nb_event=[];
        $total_event=0;
        foreach ($list_categ as $cat){
            $list_categ=$em->getRepository('EvennementBundle:Evennement')->findBy(['CatEvent'=>$cat->getId()]);
            $tab_nb_event[$cat->getId()]=count($list_categ);
            $total_event+=count($list_categ);
        }
        $tab_nb_event['all']=$total_event;


        $list_categ=$em->getRepository('EvennementBundle:CategorieEvent')->findAll();
        return $this->render('EvennementBundle:evennement:front/allevent.html.twig', array(
            'evennements' => $evennements,
            'list_categ' => $list_categ,
            'tab_nb_event' => $tab_nb_event,
            'id_categ'=>$id_categ
        ));
    }

    /**
     * Finds and displays a evennement entity.
     *
     * @Route("/resultatsearch", name="resultat_search")
     * @Method("GET")
     */
    public function resultatSearchAction(Request $request)
    {
        $data=$request->query->all();
        $cond=[];

        if(!empty($data['liste_trie']))
        {
            $tab_trie=explode('_',$data['liste_trie']);
            $cond['critere']=$tab_trie[0];
            $cond['ordre']=$tab_trie[1];
        }
        if(!empty($data['search_categ']))
    {
        $cond['CatEvent']=$data['search_categ'];
    }
        if(!empty($data['search_ville']))
        {
            $cond['ville']=$data['search_ville'];
        }
        if(!empty($data['search_prix']))
        {
            $cond['prix']=$data['search_prix'];
        }
        $em = $this->getDoctrine()->getManager();

        $evennements=$em->getRepository('EvennementBundle:Evennement')->MyFindAll($cond);

        return $this->render('EvennementBundle:evennement:front/resultatsearch.html.twig', array(
            'evennements'=>$evennements
        ));
    }

    /**
     * Finds and displays a evennement entity.
     *
     * @Route("/{id}/infoevent", name="evennement_info")
     * @Method("GET")
     */
    public function infoEventAction(Evennement $evennement,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $partici=$em->getRepository(Participant::class)->countVisitedEvent($id);

        return $this->render('EvennementBundle:evennement:front/infoevent.html.twig', array(
            'evennement' => $evennement,'participant'=>$partici

        ));
    }
    /**
     * Finds and displays a evennement entity.
     *
     * @Route("/{id}/infoeventParticip", name="evennement_infoP")
     * @Method("GET")
     */
    public function infoEventParticipAction(Evennement $evennement,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $participant=$em->getRepository(Participant::class)->countVisitedEvent($id);

        return $this->render('participant/new.html.twig', array(
            'evennement' => $evennement,'participant'=>$participant

        ));
    }



    /**
     * Creates a new evennement entity.
     *
     * @Route("/ajouterevent", name="evennement_ajouter")
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

            $file=$evennement->getImage();
            $fileName = $evennement->getId() . '_' . $this->generateUniqueFileName() . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('imageEvent'), $fileName
            );
            $evennement->setImage($fileName);
            $evennement->setUser($this->getUser());
            $em->persist($evennement);
            $em->flush();
            return $this->redirectToRoute('evennement_list', array('id' => $evennement->getId()));
        }

        return $this->render('EvennementBundle:evennement:front/new.html.twig', array(
            'evennement' => $evennement,
            'form' => $form->createView(),

        ));
    }

    /**
     * Finds and displays a evennement entity.
     *
     * @Route("/{id}/detailevent", name="evennement_detail")
     * @Method("GET")
     */
    public function showAction(Evennement $evennement)
    {
        $deleteForm = $this->createDeleteForm($evennement);

        return $this->render('EvennementBundle:evennement:front/show.html.twig', array(
            'evennement' => $evennement,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to edit an existing evennement entity.
     *
     * @Route("/{id}/modifierevent", name="evennement_modifier")
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
                    $file=$evennement->getEditImage();
if(!empty($file)) {
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

        return $this->render('EvennementBundle:evennement:front/edit.html.twig', array(
            'evennement' => $evennement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Deletes a evennement entity.
     *
     * @Route("/{id}/supprimerevent", name="evennement_supprimer")
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
            ->getForm()
        ;
    }
    private function generateUniqueFileName() {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * Deletes a evennement entity.
     *
     * @Route("/Meteo", name="meteo_affiche")
     * @Method("GET")
     */
    public function MeteoAction()
    {
        return $this->render('EvennementBundle:evennement/front:Meteo.html.twig');
    }
}
