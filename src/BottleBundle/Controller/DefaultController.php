<?php

namespace BottleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BottleBundle:Default:index.html.twig');
    }
}
