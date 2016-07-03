<?php

namespace BottleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Httpful\Request as HttpRequest;

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
            return $this->render('BottleBundle:Bottle:open.html.twig',
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

    private function exempleJerem($url)
    {
        try {
            $webPage = HttpRequest::get($url)->send();
            $webPageBody = $webPage->body;
            if ($webPageBody !== null && $webPageBody !== '' && $webPageBody !== false) {
                return $webPageBody;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
