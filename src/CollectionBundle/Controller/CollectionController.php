<?php

namespace CollectionBundle\Controller;

use BottleBundle\Entity\Bottle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CollectionController extends Controller
{
    private $em;
    public function indexAction()
    {
        return $this->render('CollectionBundle:Collection:index.html.twig');
    }

    public function getCollectionAction() {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');

        // TODO : take connected one
        $user = $userRepository->findAll()[1];

        $archived = $bottleRepository->getArchivedBottles($user);

        return $this->render('CollectionBundle:Collection:CollectionBottles.html.twig',
            array('archived' => $archived)
        );
    }
}
