<?php

namespace Horus\BackendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class LayoutController
 * @package Horus\BackendBundle\Controller
 */
class ChartController extends Controller
{

    public function mainAction()
    {

        return $this->render('HorusBackendBundle:Chart:month.html.twig', array(
            'dt' => array(),
            'dt10'        => array(),
            'dataTable1' => array()
        ));

    }

    public function monthsAction()
    {



        return $this->render('HorusBackendBundle:Chart:month.html.twig', array(
            'dt' => array(),
            'dt10'        => array()
        ));
    }

    public function globalAction()
    {



        return $this->render('HorusBackendBundle:Chart:global.html.twig', array(

        ));
    }

    public function daysAction()
    {

        return $this->render('HorusBackendBundle:Chart:days.html.twig', array(
        ));
    }

}
