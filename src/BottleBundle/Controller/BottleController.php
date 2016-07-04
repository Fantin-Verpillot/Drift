<?php

namespace BottleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure; /* /!\ Don't remove, used by the annotations /!\ */

class BottleController extends Controller
{
    private $em;

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        //OLD WAY
        /*if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            var_dump("admin");
        }
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            var_dump("user");
        }*/
        //NEXT WAY
        //$user = $this->get('security.token_storage')->getToken()->getUser();
        //if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) { ... }
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

    /**
     * @Secure(roles="ROLE_USER")
     */
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
                // TODO : get log and lat
                $locationService = $this->container->get('bottle_location');

                $bottle->setFkReceiver($user);
                $bottle->setLatitude(0);
                $bottle->setLongitude(0);
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
