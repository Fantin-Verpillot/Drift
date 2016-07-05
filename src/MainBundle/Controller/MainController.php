<?php

namespace MainBundle\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    private $em;

    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        return $this->render('MainBundle:Main:index.html.twig',
            array(
                'user'              => $user,
                'mark'              => $bottleRepository->getAverageMark($user),
                'bottleTransmitted' => $bottleRepository->countTransmittedBottle($user),
                'bottleReceived'    => $bottleRepository->countReceivedBottle($user),
                'emojis'            => $bottleRepository->countEmojiByBottle($user),
                )
        );

    }

    public function loginAction(Request $request) {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }
        return $this->render('MainBundle:Main:login.html.twig', array(
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error'         => $error,
        ));
    }


}
