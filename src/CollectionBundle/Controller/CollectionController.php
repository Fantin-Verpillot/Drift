<?php

namespace CollectionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CollectionController extends Controller
{
    private $em;

    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottles = $bottleRepository->getCollectedBottles($user);

        return $this->render('CollectionBundle:Collection:index.html.twig',
            array('bottles' => $bottles)
        );
    }

    public function deleteAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $idBottle = $request->request->get('idBottle');
        if (!empty($idBottle)) {
            $bottle = $bottleRepository->find($idBottle);
            if ($bottle !== null) {
                $bottle->setState(4);
                $this->em->persist($bottle);
                $this->em->flush();
                return $this->redirectToRoute('bottle_home');
            }
        }

        $this->get('session')->getFlashBag()->add('error', 'You failed, please try again.');
        return $this->redirectToRoute('bottle_home');

    }
    
}
