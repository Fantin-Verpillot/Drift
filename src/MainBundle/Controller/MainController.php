<?php

namespace MainBundle\Controller;

use MainBundle\Entity\User;
use JMS\SecurityExtraBundle\Annotation\Secure; /* /!\ Don't remove, used by the annotations /!\ */
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    private $em;

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        $locationService = $this->container->get('bottle_location');
        $location = $locationService->getLocationByIP($request->getClientIp());

        if ($location === null || $location[0] === null || $location[1] === null)
        {
            // London position (for center the map)
            $latitude_init  = 51.508742;
            $longitude_init = -0.120850;
        }
        else
        {
            $latitude_init = $location[0];
            $longitude_init = $location[1];
        }

        return $this->render('MainBundle:Main:index.html.twig',
            array (
                'location'          => $location,
                'user'              => $user,
                'mark'              => $bottleRepository->getAverageMark($user),
                'bottleTransmitted' => count($bottleRepository->getSentBottle($user)),
                'bottleReceived'    => $bottleRepository->countReceivedBottle($user),
                'emojis'            => $bottleRepository->countEmojiByBottle($user),
                'bottles'           => $bottleRepository->getBottlesSentByUser($user),
                'latitude_init'     => $latitude_init,
                'longitude_init'    => $longitude_init,
            )
        );
    }

    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
            if ($error !== null) {
                $this->get('session')->getFlashBag()->add('error', 'You failed, please try again');
            }
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            if ($error !== null) {
                $this->get('session')->getFlashBag()->add('error', 'You failed, please try again');
            }
            $session->remove(Security::AUTHENTICATION_ERROR);
        }
        return $this->render('MainBundle:Main:login.html.twig', array(
            'last_username'      => $session->get(Security::LAST_USERNAME),
            'error'              => $error,
        ));
    }

    public function registerAction()
    {
        return $this->render('MainBundle:Main:register.html.twig');
    }

    public function registerCheckAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $userRepository = $this->em->getRepository('MainBundle:User');
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');

        if ($username !== null && $password !== null && $email !== null
            && $username !== '' && $password !== '' && $email !== '') {
            if ($userRepository->findOneByUsername($username) !== null) {
                $this->get('session')->getFlashBag()->add('error', 'This username is already taken');
                return $this->redirectToRoute('register');
            }
            if ($userRepository->findOneByEmail($email) !== null) {
                $this->get('session')->getFlashBag()->add('error', 'You already created an account with this email');
                return $this->redirectToRoute('register');
            }

            $user = new User();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->setExperience(0);
            $user->setLevel(1);
            $user->setIsActive(true);
            $user->setRoles(array('ROLE_USER'));
            $this->em->persist($user);
            $this->em->flush();

        } else {
            $this->get('session')->getFlashBag()->add('error', 'You left some fields blank');
            return $this->redirectToRoute('register');
        }

        $this->get('session')->getFlashBag()->add('success', 'Your registration succeed, please connect');
        return $this->redirectToRoute('login');
    }
}
