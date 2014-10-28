<?php

namespace Horus\BackendBundle\Controller;

use Horus\BackendBundle\Entity\Article;

use Horus\BackendBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Class PaiementsController
 * @package Horus\BackendBundle\Controller
 */
class PaiementsController extends Controller
{

    public function indexAction()
    {
        return $this->render('HorusBackendBundle:Main:index.html.twig');

    }


}
