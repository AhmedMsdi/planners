<?php

namespace EvennementBundle\Controller;

use EvennementBundle\Entity\Evennement;
use EvennementBundle\Entity\CategorieEvent;
use EvennementBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     * @Route("/{id}/infoeventParticip", name="evennement_info")
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
                    return $this->redirectToRoute('evennement_list', array('id' => $evennement->getId()));
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


    /**
     * Lists all evennement entities.
     *
     * @Route("/{id}/byId", name="byId_task")
     * @Method("GET")
     */
    public function byidAction($id){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('EvennementBundle:Evennement')
            ->find($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }



    /**
     * Lists all evennement entities.
     *
     * @Route("/all", name="all_task")
     * @Method("GET")
     */
    public function allAction(){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('EvennementBundle:Evennement')
            ->MyFindAllMobile();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }


    /**
     * Creates a new evennement entity.
     *
     * @Route("/newTask", name="task_new")
     * @Method({"GET", "POST"})
     */
    public function newTaskAction(Request $request){
        $em= $this->getDoctrine()->getManager();
        $task= new Evennement();
        $categorieEvents = $em->getRepository('EvennementBundle:CategorieEvent')->find($request->get('CatEvent'));
        $userEvent = $em->getRepository('PiBundle:User')->find($request->get('User'));
       // var_dump($categorieEvents);
        //$catEventObj = find($request->get('CatEvent'));
        $task->setTitre($request->get('titre'));
        $task->setDescription($request->get('description'));
        $task->setContact($request->get('contact'));
        $task->setAdresse($request->get('adresse'));
        $task->setPrix($request->get('prix'));
        $task->setVille($request->get('ville'));
        $task->setCatEvent($categorieEvents);
        $task->setDateEvent(date_create($request->get('date_event')));
        $task->setTimeEvent(date_create($request->get('time_event')));
        $task->setImage($request->get('image'));
        $task->setUser($userEvent);
        $task->setEtat($request->get('etat'));
        //var_dump($task);
        $em->persist($task);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($task);
        return new JsonResponse($formatted);
    }

    /**
     * Creates a new evennement entity.
     *
     * @Route("/{id}/deleteTask", name="task_delete")
     */
    public function deleteTaskAction($id){

        $em=$this->getDoctrine()->getManager();
        $event= $em->getRepository("EvennementBundle:Evennement")->find("$id");

        $em->remove($event);
        $em->flush();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($event);
        return new JsonResponse($formatted);
    }
    /**
     * Displays a form to edit an existing evennement entity.
     *
     * @Route("/{id}/updateTask", name="task_update")
     * @Method({"GET", "POST"})
     */
    public function updateTaskAction(Request $request)
    {
        $id = $request->get('id');
        //$type= $request->get('type');


        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('EvennementBundle:Evennement')->find($id);

        $categorieEvents = $em->getRepository('EvennementBundle:CategorieEvent')->find($request->get('CatEvent'));
        $task->setTitre($request->get('titre'));
        $task->setDescription($request->get('description'));
        $task->setContact($request->get('contact'));
        $task->setAdresse($request->get('adresse'));
        $task->setPrix($request->get('prix'));
        $task->setVille($request->get('ville'));
        $task->setCatEvent($categorieEvents);
        $task->setDateEvent(date_create($request->get('date_event')));
        $task->setTimeEvent(date_create($request->get('time_event')));
        $task->setImage($request->get('image'));
        $task->setEtat($request->get('etat'));

            $em->merge($task);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($task);
            return new JsonResponse($formatted);


        }

    /**
     * Finds and displays a evennement entity.
     *
     * @Route("/{id}/EventParticipant", name="evennement_PTask")
     * @Method("GET")
     */
    public function EventParticipantAction(Evennement $evennement,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $participant=$em->getRepository(Participant::class)->countVisitedEvent($id);

        //return $this->render('participant/new.html.twig', array(
           // 'evennement' => $evennement,'participant'=>$participant

        //));

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($participant);
        return new JsonResponse($formatted);
    }
    /**
     * Lists all evennement entities.
     *
     * @Route("/MesEvent/{id}", name="MesEvennement_Task")
     * @Method("GET")
     */
    public function MesEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PiBundle:User')->find($id);
        $evennements = $em->getRepository('EvennementBundle:Evennement')->findBy(['User'=>$user->getId()]);

        //return $this->render('EvennementBundle:evennement:front/MesEvent.html.twig', array(
           // 'evennements' => $evennements,
       // ));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evennements );
        return new JsonResponse($formatted);

    }
    /**
     * Lists all categorieEvent entities.
     *
     * @Route("/indexCategorie", name="categorieevent_index")
     * @Method("GET")
     */
    public function indexCategorieAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieEvents = $em->getRepository('EvennementBundle:CategorieEvent')->findAll();

       // return $this->render('EvennementBundle:categorieevent:index.html.twig', array(
           // 'categorieEvents' => $categorieEvents,
        //));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorieEvents);
        return new JsonResponse($formatted);

    }
    /**
     * Creates a new participant entity.
     *
     * @Route("/newParicipant/{id}/{id_user}", name="participant_newP")
     * @Method({"GET", "POST"})
     */
    public function newParicipantAction(Request $request,Evennement $evennement,$id,$id_user)
    {
        $em=$this->getDoctrine()->getManager();

        $participant = new Participant();
        $event=$em->getRepository('EvennementBundle:Evennement')->find($evennement);
        $user=$em->getRepository('PiBundle:User')->find($id_user);


        $participant->setUser($user);
        $participant->setEvent($event);
        $em->persist($participant);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($participant);
        return new JsonResponse($formatted);
    }

    /**
     * Finds and displays a categorieEvent entity.
     *
     * @Route("/{id}/categorie", name="categorieevent_show")
     * @Method("GET")
     */
    public function showCategorieByAction($id)
    {

        $em= $this->getDoctrine()->getManager();
        $categorieEvent = $em->getRepository('EvennementBundle:CategorieEvent')->find($id);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorieEvent);
        return new JsonResponse($formatted);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return new \DateTime('now', (new \DateTimeZone('Africa/Tunis')));
    }

}
