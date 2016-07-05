<?php

namespace ReportBundle\Controller;

use ReportBundle\Entity\Report;
use JMS\SecurityExtraBundle\Annotation\Secure; /* /!\ Don't remove, used by the annotations /!\ */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller
{
    private $em;

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction() {

        $this->em = $this->getDoctrine()->getManager();
        $entityRepository = $this->em->getRepository('ReportBundle:Report');

        $sent = $entityRepository->findByState(0);
        $read = $entityRepository->findByState(1);
        $handled = $entityRepository->findByState(2);

        return $this->render('ReportBundle:Report:index.html.twig',
            array(
                'sent'      => $sent,
                'read'      => $read,
                'handled'   => $handled,
            ));
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     */
    public function writeReportAction() {

        return $this->render('ReportBundle:Report:write.html.twig');
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createReportAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottle = $bottleRepository->getPendingBottle($user);
        $message = $request->request->get('message');
        $send = $request->request->get('send');

        if ($send !== null) {
            $report = new Report();
            $report->constructReport($bottle, 0, $message);
            $this->em->persist($report);
            $this->em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Thanks for reporting this bottle');
            return $this->redirectToRoute('bottle_open');
        }

        return $this->redirectToRoute('report_write');
    }
}
