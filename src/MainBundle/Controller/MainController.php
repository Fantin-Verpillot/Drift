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
     */
    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        return $this->render('MainBundle:Main:index.html.twig',
            array (
                'user'              => $user,
                'mark'              => $bottleRepository->getAverageMark($user),
                'bottleTransmitted' => count($bottleRepository->getSentBottle($user)),
                'bottleReceived'    => $bottleRepository->countReceivedBottle($user),
                'emojis'            => $bottleRepository->countEmojiByBottle($user),
            )
        );
    }

    public function loginAction(Request $request)
    {
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


    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     */
    public function showGmapAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottles = $bottleRepository->getBottlesSentByUser($user);

        return $this->render('MainBundle:Main:gmap.html.twig', array(
            'bottles' => $bottles, 'toto' => "HELLO"));
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
                $this->get('session')->getFlashBag()->add('error', 'This username is already taken.');
                return $this->redirectToRoute('register');
            }
            if ($userRepository->findOneByEmail($email) !== null) {
                $this->get('session')->getFlashBag()->add('error', 'You already created an account with this email.');
                return $this->redirectToRoute('register');
            }

            $user = new User();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->setExperience(0);
            $user->setLevel(1);
            $user->setRoles(array('ROLE_USER'));
            $this->em->persist($user);
            $this->em->flush();

        } else {
            $this->get('session')->getFlashBag()->add('error', 'You left some fields blank.');
            return $this->redirectToRoute('register');
        }

        $this->get('session')->getFlashBag()->add('success', 'Your registration succeed, please connect.');
        return $this->redirectToRoute('login');
    }
}
