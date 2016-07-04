<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('MainBundle:Main:index.html.twig');
    }

    public function loginAction() {
        return $this->render('MainBundle:Main:login.html.twig');
    }
}
