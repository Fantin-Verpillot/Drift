<?php

namespace BottleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BottleController extends Controller
{
    private $em;
    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $userRepository = $this->em->getRepository('MainBundle:User');
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        // TODO : take connected one
        $user = $userRepository->findAll()[1];

        $pendingBottle = $bottleRepository->getPendingBottle($user);
        if ($pendingBottle !== null) {
            return $this->render('BottleBundle:Bottle:bottle.html.twig',
                array('bottle' => $pendingBottle)
            );
        }
        return $this->render('BottleBundle:Bottle:index.html.twig');
    }

    public function openBottleAction(Request $request) {
        //check if a bottle has not be oppened
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');

        // TODO : take connected one
        $user = $userRepository->findAll()[1];

        // Check if there is a pending (open but not marked/emojied) bottle
        $bottle = $bottleRepository->getPendingBottle($user);
        if ($bottle === null) {
            $bottle = $bottleRepository->getAvailableBottle($user);
            if ($bottle !== null) {
                // TODO : get ip addr
                $ip = '8.8.8.8';
                $locationService = $this->container->get('bottle_location');

                $bottle->setFkReceiver($user);
                $bottle->setLatitude($locationService->myservice($ip)[0]);
                $bottle->setLongitude($locationService->myservice($ip)[1]);
                $bottle->setState(2);
                //$this->em->persist($bottle);
                //$this->em->flush();
            }
        }
        return $this->render('BottleBundle:Bottle:bottle.html.twig',
            array('bottle' => $bottle)
        );
    }
}
