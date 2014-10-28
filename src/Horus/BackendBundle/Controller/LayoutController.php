<?php

namespace Horus\BackendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LayoutController
 * @package Horus\BackendBundle\Controller
 */
class LayoutController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainMenuAction()
    {
        return $this->render('HorusBackendBundle:Slots:mainmenu.html.twig');

    }



    /**
     * Get card of user
     */
    public function cardAction(Request $request)
    {
        $session = $request->getSession();
        $stars = $session->get('stars', array());

        return $this->render('HorusBackendBundle:Slots:card.html.twig', array(
            'stars' => isset($stars['products'])? $stars['products'] : array(),
            'total' => isset($stars['totalht']) ? $stars['totalht'] : null
        ));

    }

    /**
     * Lists all Comments entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function commentsAction()
    {
//        $entities = $this->getRepository('Comments')->findBy(array(), array('id' => 'DESC'), 7);

        return $this->render('HorusBackendBundle:Slots:notifications.html.twig', array(
            'notifications' => array()
        ));
    }


    /**
     * Get alerting of emails
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function alertingAction(Request $request)
    {
       return $this->render('HorusBackendBundle:Slots:alerting.html.twig', array(
            'commentaires' => 1
        ));
    }


    /**
     * Custom Theme
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function themeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $configuration = $em->getRepository('HorusBackendBundle:Configuration')->find(1);
        return $this->render('HorusBackendBundle:Slots:theme.html.twig', array('configuration' => $configuration));
    }

    /**
     * Custom Theme
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function leftmenuAction()
    {
        return $this->render('HorusBackendBundle:Slots:leftmenu.html.twig');
    }

    /**
     * Custom Theme
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function notificationsAction()
    {
        
        $notifications = array();

        return $this->render('HorusBackendBundle:Slots:notifications.html.twig', array('notifications' => $notifications));
    }


    /**
     * get Ip Visitor
     * @return type
     */
    public function getIpVisitorAction()
    {
        $ip = $this->container->get('request')->getClientIp();
        return $this->container->get('templating')->renderResponse('HorusBackendBundle:Slots:_ipVisitor.html.twig', array(
            'ip' => $ip
        ));
    }
}
