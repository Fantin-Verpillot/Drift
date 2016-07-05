<?php

namespace BottleBundle\Controller;

use BottleBundle\Entity\Bottle;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure; /* /!\ Don't remove, used by the annotations /!\ */
use Symfony\Component\HttpFoundation\Request;

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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function openBottleAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $emojiRepository = $this->em->getRepository('BottleBundle:Emoji');
        $userRepository = $this->em->getRepository('MainBundle:User');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $emojis = $emojiRepository->findAll();

        $bottle = $bottleRepository->getPendingBottle($user);
        if ($bottle === null) {
            $bottle = $bottleRepository->getAvailableBottle($user);
            if ($bottle !== null) {
                if ($bottle->getSourceRole() === 'ROLE_USER') {
                    $locationService = $this->container->get('bottle_location');
                    $location = $locationService->getLocationByIP($request->getClientIp());

                    $bottle->setFkReceiver($user);
                    $bottle->setReceivedDate(new DateTime('NOW', new DateTimeZone('Europe/Paris')));
                    $bottle->setLatitude($locationService->getLocationByIP($location[0]));
                    $bottle->setLongitude($locationService->getLocationByIP($location[1]));
                    $bottle->setState(2);
                    $this->em->persist($bottle);
                    $this->em->flush();

                    if ($userRepository->earnExperience($user, 5)) {
                        $this->get('session')->getFlashBag()->add('success', 'Congrats! Level up to ' . $user->getLevel() . '!');
                    }
                } else {
                    $bottle->setReceivedDate(new DateTime('NOW', new DateTimeZone('Europe/Paris')));
                    $bottle->setState(2);
                    $this->em->persist($bottle);
                    $this->em->flush();
                }
            }
        }

        return $this->render('BottleBundle:Bottle:open.html.twig',
            array('bottle' => $bottle,
                  'emojis' => $emojis,
            )
        );
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     */
    public function writeBottleAction() {
        return $this->render('BottleBundle:Bottle:write.html.twig');
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createBottleAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userRepository = $this->em->getRepository('MainBundle:User');

        $message = $request->request->get('message');
        $image = $request->request->get('image');
        $send = $request->request->get('send');

        if ($message !== '') {
            $bottle = new Bottle();
            $state = $send !== null ? 1 : 0;
            $bottle->constructBottle($user, $message, $state, $image === '' ? null : $image);
            $this->em->persist($bottle);

            if ($state === 1) {
                if ($userRepository->earnExperience($user, 10)) {
                    $this->get('session')->getFlashBag()->add('success', 'Congrats! Level up to ' . $user->getLevel() . '!');
                }
            }
            $this->em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Bottle successfully sent.');
            return $this->redirectToRoute('bottle_home');
        }

        $this->get('session')->getFlashBag()->add('error', 'Some fields had bad format.'); //TODO : rewrite fields
        return $this->redirectToRoute('bottle_write');
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function evaluateBottleAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $bottle = $bottleRepository->getPendingBottle($user);
        $success = false;

        if ($bottle != null) {
            if ($bottle->getSourceRole() === 'ROLE_USER') {
                $mark = $request->request->get('mark');
                $idEmoji = $request->request->get('emoji');
                $success = $this->manageUserBottle($bottle, $mark, $idEmoji);
            } else {
                $success = $this->manageAdminBottle($bottle);
            }
        }

        if ($success) {
            $this->get('session')->getFlashBag()->add('success', 'Bottle successfully saved.');
        } else {
            $this->get('session')->getFlashBag()->add('success', 'Some fields had bad format.');
        }

        return $this->redirectToRoute('bottle_home');
    }

    private function manageUserBottle($bottle, $mark, $idEmoji) {
        $this->em = $this->getDoctrine()->getManager();
        $userRepository = $this->em->getRepository('MainBundle:User');
        $emojiRepository = $this->em->getRepository('BottleBundle:Emoji');
        if ($mark !== '' && $idEmoji != '') {
            $emoji = $emojiRepository->find($idEmoji);
            if ($emoji != null) {
                $bottle->setMark($mark);
                $bottle->setFkEmoji($emoji);
                $bottle->setState(3);
                $this->em->persist($bottle);
                $this->em->flush();

                if ($userRepository->earnExperience($bottle->getFkTransmitter(), $mark * 10 + $emoji->getWeight())) {
                    // TODO : add flashbag level up next connection
                }
                return true;
            }
        }
        return false;
    }

    private function manageAdminBottle($bottle) {
        $this->em = $this->getDoctrine()->getManager();
        $bottle->setState(3);
        $this->em->persist($bottle);
        $this->em->flush();
        return true;
    }
}
