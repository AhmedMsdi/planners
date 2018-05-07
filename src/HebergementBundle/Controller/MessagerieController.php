<?php

namespace HebergementBundle\Controller;

use HebergementBundle\Entity\Hebergement;
use HebergementBundle\Entity\Messagerie;
use PiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Messagerie controller.
 *
 */
class MessagerieController extends Controller
{

    public function editMAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $messageries = $em->getRepository('HebergementBundle:Messagerie')->find($id);
        $messageries->setEtat(2);
        $em->persist($messageries);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($messageries);
        return new JsonResponse($formatted);

    }

    public function allAction()
    {
        $messagerie = $this->getDoctrine()->getManager()
            ->getRepository('HebergementBundle:Messagerie')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($messagerie );
        return new JsonResponse($formatted);
    }

    public function WSdeleteAction(Messagerie $messagerie){
        $em=$this->getDoctrine()->getManager();
        $em->remove($messagerie);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($messagerie);
        return new JsonResponse($formatted);
    }

    public function WSmailAction(Request $request, $id){
        $user = $this->getDoctrine()->getManager()
            ->getRepository('PiBundle:User')->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }


    public function WSnewMessAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $messageries = new Messagerie();
        $DD= DateTime::createFromFormat('Y-m-d', $request->get('dateDebut'));
        $DF= DateTime::createFromFormat('Y-m-d', $request->get('dateFin'));
        $messageries->setDatedebut($DD);
        $messageries->setDatefin($DF);
        $messageries->setNbrPerson($request->get('nbrPerson'));
        $messageries->setIdheb($request->get('idheb'));
        $messageries->setIdClient($request->get('idClient'));
        $messageries->setTypemessage('Client');
        $messageries->setIdUser($request->get('idUser'));
        $messageries->setEtat(1);
        $em->persist($messageries);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($messageries);
        return new JsonResponse($formatted);
    }

    /**
     * Lists all messagerie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messageries = $em->getRepository('HebergementBundle:Messagerie')->createQueryBuilder('e')
            ->addORderBy('e.datedebut', 'ASC')
            ->getQuery()
            ->execute();

        return $this->render('HebergementBundle:messagerie:index.html.twig', array(
            'messageries' => $messageries,
        ));
    }

    public function indexAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messageries = $em->getRepository('HebergementBundle:Messagerie')->createQueryBuilder('e')
            ->addORderBy('e.datedebut', 'ASC')
            ->getQuery()
            ->execute();

        return $this->render('HebergementBundle:messagerie:indexAdmin.html', array(
            'messageries' => $messageries,
        ));
    }

    /**
     * Creates a new messagerie entity.
     *
     */
    public function newAction(Request $request,$idh)
    {
        $req=$_POST['hebergementbundle_messagerie'];



        global $kernel;
        $em = $this->getDoctrine()->getManager();
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user === 'anon.') {
            $this->addFlash('danger', 'veuiller Connecter!!!');
            return $this->redirectToRoute('hebergement_show', array('id' => $idh));
        }else{
            $heb = $em->getRepository('HebergementBundle:Hebergement')->find($idh);
            $messageries = new Messagerie();
            $messageries->setIdheb($heb->getId());
            $messageries->setIdClient($user);
            $messageries->setTypemessage('Client');
            $u = $em->getRepository('PiBundle:User')->find($heb->getIdUser());
            $messageries->setIdUser($u->getId());
            $messageries->setDatedebut(new \DateTime($req['datedebut']));
            $messageries->setDatefin(new \DateTime($req['datefin']));
            $messageries->setEtat(1);
            $messageries->setNbrPerson($req['nbrPerson']);
            $em->persist($messageries);
            $em->flush();
            if ($user->getId()!=$messageries->getIdUser())
                return $this->redirectToRoute('hebergement_show', array('id' => $idh));
            else
                return $this->redirectToRoute('hebergement_index');

        }



    }

    /**
     * Finds and displays a messagerie entity.
     *
     */
    public function showAction(Messagerie $messagerie)
    {
        $deleteForm = $this->createDeleteForm($messagerie);

        return $this->render('messagerie/show.html.twig', array(
            'messagerie' => $messagerie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing messagerie entity.
     *
     */
    public function editAction(Request $request, $id)
    {

        global $kernel;
        $em = $this->getDoctrine()->getManager();
        $mes = $em->getRepository('HebergementBundle:Messagerie')->find($id);

        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user === 'anon.') {
            $this->addFlash('danger', 'veuiller Connecter!!!');
            return $this->redirectToRoute('hebergement_show', array('id' => $mes->getIdh()));
        }else{

            $messageries = $em->getRepository('HebergementBundle:Messagerie')->find($id);
            $messageries->setEtat(2);
            $em->persist($messageries);
            $em->flush();

            if ($user->getId()!=$messageries->getIdUser())
                return $this->redirectToRoute('hebergement_show', array('id' => $messageries->getIdheb()));
            else
                return $this->redirectToRoute('messagerie_index');
        }
    }

    /**
     * Deletes a messagerie entity.
     *
     */
    public function deleteAction(Request $request, Messagerie $messagerie)
    {
        var_dump($messagerie);
        $em = $this->getDoctrine()->getManager();
        $em->remove($messagerie);
        $em->flush();


        return $this->redirectToRoute('messagerie_index');
    }

    /**
     * Creates a form to delete a messagerie entity.
     *
     * @param Messagerie $messagerie The messagerie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Messagerie $messagerie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('messagerie_delete', array('id' => $messagerie->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
