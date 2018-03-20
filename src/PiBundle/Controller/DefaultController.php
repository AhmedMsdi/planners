<?php

namespace PiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DefaultController extends Controller
{

    private $tokenManager;
    public function indexAction()
    {
        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        return $this->render('PiBundle:Default:index.html.twig',
            array(
                'csrf_token' => $csrfToken,
            ) );
    }
    public function profilAction()
    {
        return $this->render('PiBundle:Default:profil.html.twig'

    );
    }
}
