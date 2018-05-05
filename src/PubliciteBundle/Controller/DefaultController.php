<?php

namespace PubliciteBundle\Controller;

use PubliciteBundle\Entity\Publicite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PubliciteBundle:Default:index.html.twig');
    }

    public function allAction(){
        $em= $this->getDoctrine()->getManager();
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('PubliciteBundle:Publicite')
            ->findAll();
        $query = $em->createQuery('SELECT u FROM PubliciteBundle:Publicite u ');
        $users = $query->getResult();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($users);
        return new JsonResponse($formatted);
    }

    public function byidAction($id){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('PubliciteBundle:Publicite')
            ->find($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request){
        $em= $this->getDoctrine()->getManager();
        $task= new Publicite();
        $task->setText($request->get('text'));
        $task->setDescription($request->get('description'));
        $task->setSiteWeb($request->get('siteweb'));
        $task->setTags($request->get('tags'));
        $task->setImage($request->get('image'));


        $em->persist($task);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($task);
        return new JsonResponse($formatted);
    }

    public function deleteAction(Publicite $publicite){
        $em=$this->getDoctrine()->getManager();
        //   $commentaire=$em->getRepository(Article::class)->find($id);

        $em->remove($publicite);
        $em->flush();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($publicite);
        return new JsonResponse($formatted);
    }

    public function allArticleAction(){
        $em= $this->getDoctrine()->getManager();
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('PubliciteBundle:Article')
            ->find(1);
        $query = $em->createQuery('SELECT u.contenu FROM PubliciteBundle:Article u WHERE u.id=1 ');
        $users = $query->getResult();
        $qq=$tasks->getContenu();
       // $aa='https://www.instagram.com/';
var_dump($qq);
       header('Location: '.$qq );

        exit();
    }

    public function uploadImageAction(Request $request)
    {
        $imagename = $request->request->get('imagename');
        $Imagecode = $request->request->get('image');
        define('UPLOAD_DIR', 'C:/wamp64/www/planners/web/');
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
