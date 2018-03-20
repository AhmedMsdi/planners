<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
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

}
