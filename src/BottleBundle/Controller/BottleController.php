<?php

namespace BottleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BottleController extends Controller
{
    private $em;
    public function indexAction()
    {

        return $this->render('BottleBundle:Bottle:index.html.twig');
    }

    public function openBottleAction(Request $request) {
        $this->em = $this->getDoctrine()->getEntityManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');

        // TODO : take connected one
        $user = $userRepository->findAll()[1];

        $bottle = $bottleRepository->getBottleToOpen($user);
        if ($bottle !== null) {
            $bottle->setFkReceiver($user);
            $bottle->setLatitude(0);
            $bottle->setLongitude(0);
            //$this->em->persist($bottle);
            //$this->em->flush();
        }

        $locationService = $this->container->get('bottle_location');
        var_dump($locationService->myservice());

        return $this->render('BottleBundle:Bottle:open.html.twig',
            array('bottle' => $bottle)
        );
    }
}
