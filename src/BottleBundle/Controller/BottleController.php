<?php

namespace BottleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure; /* /!\ Don't remove, used by the annotations /!\ */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Exception\NotImplementedException;

class BottleController extends Controller
{
    private $em;

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
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

        if ($bottleRepository->getPendingBottle($user) !== null) {
            return $this->redirectToRoute('bottle_open');
        }
        return $this->render('BottleBundle:Bottle:index.html.twig');
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     */
    public function openBottleAction() {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $emojiRepository = $this->em->getRepository('BottleBundle:Emoji');

        // TODO : take connected one
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $emojis = $emojiRepository->findAll();

        $bottle = $bottleRepository->getPendingBottle($user);
        if ($bottle === null) {
            $bottle = $bottleRepository->getAvailableBottle($user);
            if ($bottle !== null) {
                $locationService = $this->container->get('bottle_location');
                $ip = $locationService->getClientIpEnv();

                $bottle->setFkReceiver($user);
                $bottle->setLatitude($locationService->myservice($ip)[0]);
                $bottle->setLongitude($locationService->myservice($ip)[1]);
                $bottle->setState(2);
                $this->em->persist($bottle);
                $this->em->flush();
            }
        }

        return $this->render('BottleBundle:Bottle:open.html.twig',
            array('bottle' => $bottle,
                  'emojis' => $emojis,
                  'mark'=> $bottleRepository->getAverageMark($user),
                  'bottleTransmitted' => $bottleRepository->countTransmittedBottle($user),
                  'bottleReceived' => $bottleRepository->countReceivedBottle($user),
                )
        );
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     */
    public function writeBottleAction() {
        throw new NotImplementedException('This feature is comming soon!');
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     */
    public function evaluateBottleAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $emojiRepository = $this->em->getRepository('BottleBundle:Emoji');

        $mark = $request->request->get('mark');
        $idEmoji = $request->request->get('emoji');

        if ($mark !== '' && $idEmoji != '') {
            $bottle = $bottleRepository->getPendingBottle($user);
            $emoji = $emojiRepository->find($idEmoji);
            if ($bottle !== null && $emoji != null) {
                $bottle->setMark($mark);
                $bottle->setFkEmoji($emoji);
                $bottle->setState(3);
                $this->em->persist($bottle);
                $this->em->flush();
            }
        }

        return $this->redirectToRoute('bottle_home');
    }
}
