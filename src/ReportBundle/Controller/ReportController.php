<?php

namespace ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    public function indexAction()
    {
        return $this->render('ReportBundle:Report:index.html.twig');
    }
}
