<?php

namespace Horus\BackendBundle\Controller;


use Horus\BackendBundle\Document\Actions;
use Horus\BackendBundle\Form\AdministrateursType;
use Horus\BackendBundle\Form\ConfigurationType;
use Horus\BackendBundle\Entity\Administrateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Class NotificationsController
 * @package Horus\BackendBundle\Controller
 */
class NotificationsController extends Controller
{

    /**
     *  Get Produits
     * @return type
     */
    public function getNotificationProduit()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $actions = $dm->getRepository('HorusBackendBundle:Actions')->findBy(array(), array('dateCreated' => 'DESC'), 5);

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:lastactions.html.twig', array('actions' => $actions)
        );
    }



}
