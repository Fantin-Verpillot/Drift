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
        $reportRepository = $this->em->getRepository('ReportBundle:Report');

        $sent = $reportRepository->findByState(0);
        $read = $reportRepository->findByState(1);

        return $this->render('ReportBundle:Report:index.html.twig',
            array(
                'sent'      => $sent,
                'read'      => $read
            ));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function displayReportAction($id)
    {
        $this->em = $this->getDoctrine()->getManager();
        $reportRepository = $this->em->getRepository('ReportBundle:Report');
        $report = $reportRepository->find($id);
        if ($report !== null) {
            $report->setState(1);
            $this->em->persist($report);
            $this->em->flush();
            return $this->render('ReportBundle:Report:display.html.twig', array('report' => $report));
        }
        $this->get('session')->getFlashBag()->add('error', 'This report doesn\'t exists, please try again');
        return $this->redirectToRoute('report_homepage');
    }

    /**
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param Request $request
     */
    public function createReportAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $bottleRepository = $this->em->getRepository('BottleBundle:Bottle');
        $reportRepository = $this->em->getRepository('ReportBundle:Report');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $bottle = $bottleRepository->getPendingBottle($user);

        if (!empty($bottle)) {
            if ($reportRepository->findOneByFkBottle($bottle) === null) {
                $report = new Report();
                $report->constructReport($bottle, 0);
                $this->em->persist($report);
                $this->em->flush();
                $this->get('session')->getFlashBag()->add('success', 'The bottle has been reported to an administrator');
                return $this->redirectToRoute('bottle_open');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'You have already reported this bottle to an administrator');
                return $this->redirectToRoute('bottle_open');
            }
        }

        $this->get('session')->getFlashBag()->add('error', 'You failed, please try again');
        return $this->redirectToRoute('bottle_home');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function banUserAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $userRepository = $this->em->getRepository('MainBundle:User');
        $reportRepository = $this->em->getRepository('ReportBundle:Report');
        $id = $request->request->get('id');
        $idReport = $request->request->get('idReport');

        
        if (!empty($id) && !empty($idReport)) {
            $user = $userRepository->find($id);
            $report = $reportRepository->find($idReport);

            if ($user !== null && $report !== null) {
                if ($user->getIsActive()) {
                    $user->setIsActive(false);
                    $this->em->persist($user);
                    $this->em->flush();
                    $this->get('session')->getFlashBag()->add('success', 'You banished the user '. $user->getUsername());
                    return $this->redirectToRoute('report_display', array('id' => $report->getId()));
                } else {
                    $this->get('session')->getFlashBag()->add('error', 'The user ' . $user->getUsername().' is already banished');
                    return $this->redirectToRoute('report_display', array('id' => $report->getId()));
                }
            }
        }

        $this->get('session')->getFlashBag()->add('error', 'You failed, please try again');
        return $this->redirectToRoute('report_homepage');
    }
}
