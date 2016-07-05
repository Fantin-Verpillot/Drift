<?php

namespace CollectionBundle\Controller;

use BottleBundle\Entity\Bottle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CollectionController extends Controller
{
    private $em;

    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');

        // TODO : take connected one
        $user = $userRepository->findAll()[1];

        $archived = $bottleRepository->getCollectedBottles($user);

        return $this->render('CollectionBundle:Collection:index.html.twig',
            array('archived' => $archived)
        );
    }

    public function deleteAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $userRepository = $this->em->getRepository('MainBundle:User');

        // TODO : take connected one
        $user = $userRepository->findAll()[1];

        $archived = $bottleRepository->getCollectedBottles($user);

        $idBottle = $request->request->get('idBottle');

        $res = "no corresponding bottle";
        foreach ($archived as $bottle)
        {
            if ($bottle->getId() == $idBottle)
            {
                $bottle->setState(4);
                $this->em->persist($bottle);
                $this->em->flush();
            }
        }

        return $this->render('CollectionBundle:Collection:index.html.twig',
            array('res' => $res, 'archived' => $archived)
        );
    }
    
}
