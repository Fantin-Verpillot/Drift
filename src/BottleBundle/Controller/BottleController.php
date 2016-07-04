<?php

namespace BottleBundle\Controller;

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
        /*
         * $this->get('security.token_storage')->getToken()->getUser();
         * $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
        */

        $this->em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        $pendingBottle = $bottleRepository->getPendingBottle($user);
        if ($pendingBottle !== null) {
            return $this->render('BottleBundle:Bottle:open.html.twig',
                array('bottle' => $pendingBottle)
            );
        }
        return $this->render('BottleBundle:Bottle:index.html.twig');
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function openBottleAction() {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        // TODO : take connected one
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $bottle = $bottleRepository->getPendingBottle($user);
        if ($bottle === null) {
            $bottle = $bottleRepository->getAvailableBottle($user);
            if ($bottle !== null) {
                $locationService = $this->container->get('bottle_location');
                $ip = $locationService->get_client_ip_env();

                $bottle->setFkReceiver($user);
                $bottle->setLatitude($locationService->myservice($ip)[0]);
                $bottle->setLongitude($locationService->myservice($ip)[1]);
                $bottle->setState(2);
                $this->em->persist($bottle);
                $this->em->flush();
            }
        }
        return $this->render('BottleBundle:Bottle:open.html.twig',
            array('bottle' => $bottle)
        );
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function writeBottleAction() {
        return $this->render('BottleBundle:Bottle:index.html.twig');
    }
}
