<?php

namespace CollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    private $em;
    public function indexAction()
    {
        /*$this->em = $this->getDoctrine().getManager();
        $bottleRepository = $this->em->getRepository("BottleBundle:Bottle");*/
        return $this->render('CollectionBundle:Default:index.html.twig');
    }
}
