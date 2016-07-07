<?php

namespace CollectionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure; /* /!\ Don't remove, used by the annotations /!\ */

class CollectionController extends Controller
{
    private $em;

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     */
    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottles = $bottleRepository->getCollectedBottles($user);

        if (count($bottles) === 0) {
            $this->get('session')->getFlashBag()->add('error', 'Your collection is empty');
            return $this->redirectToRoute('main_home');
        }

        return $this->render('CollectionBundle:Collection:index.html.twig',
            array('bottles' => $bottles)
        );
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function displaySavedBottleAction($id)
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');

        $bottle = $bottleRepository->find($id);
        if ($bottle === null || $bottle->getState() != 3) {
            $this->get('session')->getFlashBag()->add('error', 'This bottle doesn\'t exists in your collection, please try again');
            return $this->redirectToRoute('collection_home');
        }

        return $this->render('CollectionBundle:Collection:display.html.twig',
            array('bottle' => $bottle)
        );
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function displaySavedBottleAdminAction($id)
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');

        $bottleAdmin = $bottleAdminRepository->find($id);
        if ($bottleAdmin === null || $bottleAdmin->getState() != 3) {
            $this->get('session')->getFlashBag()->add('error', 'This special bottle doesn\'t exists in your collection, please try again');
            return $this->redirectToRoute('collection_home');
        }

        return $this->render('CollectionBundle:Collection:display.html.twig',
            array('bottle' => $bottleAdmin)
        );
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteBottleAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idBottle = $request->request->get('idBottle');
        if (!empty($idBottle)) {
            $bottle = $bottleRepository->find($idBottle);
            if ($bottle !== null && $bottle->getFkReceiver()->getId() === $user->getId()) {
                $bottle->setState(4);
                $this->em->persist($bottle);
                $this->em->flush();
                $this->get('session')->getFlashBag()->add('success', 'You thrown this bottle away from your collection');
                return $this->redirectToRoute('collection_home');
            }
        }

        $this->get('session')->getFlashBag()->add('error', 'This bottle doesn\'t exists in your collection, please try again');
        return $this->redirectToRoute('collection_home');
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteBottleAdminAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleAdminRepository = $this->em->getRepository('BottleBundle:BottleAdmin');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idBottle = $request->request->get('idBottle');
        if (!empty($idBottle)) {
            $bottleAdmin = $bottleAdminRepository->find($idBottle);
            if ($bottleAdmin !== null && $bottleAdmin->getFkReceiver()->getId() === $user->getId()) {
                $bottleAdmin->setState(4);
                $this->em->persist($bottleAdmin);
                $this->em->flush();
                $this->get('session')->getFlashBag()->add('success', 'You thrown this special bottle away from your collection');
                return $this->redirectToRoute('collection_home');
            }
        }

        $this->get('session')->getFlashBag()->add('error', 'This special bottle doesn\'t exists in your collection, please try again');
        return $this->redirectToRoute('collection_home');
    }
    
}
