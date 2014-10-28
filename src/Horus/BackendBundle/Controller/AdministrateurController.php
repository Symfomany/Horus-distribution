<?php

namespace Horus\BackendBundle\Controller;


use Horus\BackendBundle\Form\AdministrateursType;
use Horus\BackendBundle\Form\ConfigurationType;
use Horus\BackendBundle\Entity\Administrateur;
use Horus\BackendBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class AdministrateurController
 * @package Horus\BackendBundle\Controller
 */
class AdministrateurController extends Controller
{

    /**
     *  Login Action
     * @return type
     */
    public function deniedAction(Request $request)
    {

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Pages:denied.html.twig'
        );
    }


    /**
     *  Configuration
     * @return type
     */
    public function configurationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $configuration = $em->getRepository('HorusBackendBundle:Configuration')->find(1);

        $form = $this->createForm(new ConfigurationType(), $configuration);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em->persist($configuration);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "La configuration a été modifiée"
            );

            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Configuration', 'a édité la configuration','glyphicon glyphicon-cog');


            return $this->redirect($this->generateUrl('horus_site_main'));
        }

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Pages:configuration.html.twig', array(
                'form' => $form->createView(),
                'configuration' => $configuration
            )
        );
    }

    /**
     * Statistiques
     * @return type
     */
    public function infosAction()
    {

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Slots:infos.html.twig', array(
            )
        );
    }

    /**
     *  All Administrateurs
     * @return type
     */
    public function administrateursAction()
    {
        $em = $this->getDoctrine()->getManager();
        $administrateurs = $em->getRepository('HorusBackendBundle:Administrateur')->findAll();

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:administrateurs.html.twig', array(
                'administrateurs' => $administrateurs
            )
        );
    }

    /**
     *  All Online Administrateurs
     * @return type
     */
    public function onlineAction()
    {
        $em = $this->getDoctrine()->getManager();
        $admins = $em->getRepository('HorusBackendBundle:Administrateur')->findAll();

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:online.html.twig', array('admins' => $admins)
        );
    }

    /**
     *  All last messages of administrateurs
     * @return type
     */
    public function lastmessagerieAction()
    {
        $messages = array();

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:lastmessages.html.twig', array('messages' => $messages)
        );
    }

    /**
     *  All last messages of administrateurs
     * @return type
     */
    public function allmessagerieAction()
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            array(),
            $this->get('request')->query->get('page', 1) /*page number*/,
            10
        );

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:allmessages.html.twig', array('messages' => $pagination)
        );
    }

    /**
     *  All last actions of administrateurs
     * @return type
     */
    public function lastactionsAction()
    {
       
        $actions = array();

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:lastactions.html.twig', array('actions' => $actions)
        );
    }

    /**
     *  All actions of administrateurs
     * @return type
     */
    public function allactionsAction()
    {
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            array(),
            $this->get('request')->query->get('page', 1) /*page number*/,
            10
        );

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:allactions.html.twig', array('actions' => $pagination)
        );
    }


    /**
     *  Last notify of administrateurs
     * @return type
     */
    public function lastnotifyAction()
    {
        $notifs = array();

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:lastnotify.html.twig', array('notifications' => $notifs)
        );
    }


    /**
     *  All actions of administrateurs
     * @return type
     */
    public function allnotificationsAction()
    {
        $notifs =  array();
        $display = $this->container->get('request')->get('display', 15);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $notifs,
            $this->get('request')->query->get('page', 1) /*page number*/,
            $display
        );

        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:allnotifications.html.twig', array('notifs' => $pagination)
        );
    }

    /**
     *  All actions of  one administrateur
     * @return type
     */
    public function allactionsbyadministratorsAction(Administrateur $id)
    {

        $actions = array();
        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:allactionsbyadministrateurs.html.twig',
            array(
                'actions' => $actions,
                'administrateur' => $id,
            )
        );
    }

    /**
     * @return type
     */
    public function myaccountAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $session =  $this->get('session');

        $administrateur = $this->get('security.context')->getToken()->getUser();

        $actions = array();

        $form = $this->createForm(new AdministrateursType(), $administrateur);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $ville = $form['ville']->getData();

            $villesproxymite = $em->getRepository('HorusBackendBundle:Villes')->findIdByVilleAndZipcode($ville);
            if (!empty($villesproxymite)) {
                $villesproxymite = $villesproxymite[0];
                $session->set('place', $villesproxymite->getNomVille());
                $administrateur->setVille($villesproxymite->getNomVille());
                $administrateur->setZipcode($villesproxymite->getCodePostal());
                $administrateur->setLongitude($villesproxymite->getLongitude());
                $administrateur->setLatitude($villesproxymite->getLatitude());
            }
            $administrateur->upload($administrateur->getId());
            $administrateur->setUpdatedAt(new \Datetime('now'));
            $administrateur->setIp($this->container->get('request')->getClientIp());

            $mdp = $form['password']->getData();

            if(!empty($mdp)){
                $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
                $newpass = $encoder->encodePassword($mdp, $administrateur->getSalt());
                $administrateur->setPassword($newpass);
            }

            $em->persist($administrateur);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "Le compte a été modifiée"
            );

            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Edition', 'a édité son compte','glyphicon glyphicon-user');


            return $this->redirect($this->generateUrl('horus_site_myaccount'));
        }


        return $this->get('templating')->renderResponse(
            'HorusBackendBundle:Administrateurs:myaccount.html.twig',
            array(
                'form' => $form->createView(),
                'actions' => $actions,
            )
        );
    }


    /**
     * Remove a administrateur
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeadministrateurAction(Administrateur $id)
    {
        $em = $this->getDoctrine()->getManager();
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "L'administrateur  ".$id->getFirstname()." ".$id->getLastname()." vient d'être supprimée"
        );

        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'administrateur a bien été supprimée"
        );

        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Suppression', 'a supprimé un administrateur','glyphicon glyphicon-remove');

        return $this->redirect($this->generateUrl('horus_site_administrateurs'));
    }


    /**
     * Edit a Administrateur
     * @param Famille $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editadministrateurAction(Administrateur $id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new AdministrateursType(), $id);
        $form->handleRequest($request);

        $actions = array();

        if ($form->isValid()) {
            $id->upload($id->getId());
            $id->setUpdatedAt(new \Datetime('now'));
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "L'administrateur a bien été editée"
            );
            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "L'administrateur  ".$id->getFirstname()." ".$id->getLastname()." vient d'être modifié"
            );

            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Edition', 'a édité un administrateur','glyphicon glyphicon-pencil');


            return $this->redirect($this->generateUrl('horus_site_administrateurs'));
        }

        return $this->render('HorusBackendBundle:Administrateurs:editadministrateur.html.twig',
            array(
                'form' => $form->createView(),
                'administrateur' => $id,
                'actions' => $actions,
            )
        );
    }



    /**
     * Write a Administrateur
     * @param Famille $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function writeadministrateurAction(Administrateur $id)
    {
        $request = $this->getRequest();

        $form = $this->createForm(new ContactType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $subject = $form['subject']->getData();
            $content = $form['content']->getData();
            $criticite = $form['criticite']->getData();

            $this->email = $this->container->get('email');
            $this->email->send(null, 'HorusBackendBundle:Mails:writeadministrateur.html.twig', "Un administrateur vous a ecrit un message ".$subject, $id->getEmail(), null,
                array( 'content' => $content), null, null, null, $criticite
            );
            $this->get('session')->getFlashBag()->add(
                'success',
                "L'email à l'administrateur a bien été envoyé"
            );
            return $this->redirect($this->generateUrl('horus_site_administrateurs'));
        }

        return $this->render('HorusBackendBundle:Administrateurs:writeadministrateur.html.twig',
            array(
                'form' => $form->createView(),
                'administrateur' => $id,
            )
        );
    }



    /**
     * Add a Administrateur
     * @param Famille $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createadministrateurAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $session =  $this->get('session');

        $administrateur = new Administrateur();

        $form = $this->createForm(new AdministrateursType(), $administrateur);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $administrateur->upload($administrateur->getId());

            $administrateur->setDateCreated(new \Datetime('now'));

            $ville = $form['ville']->getData();

            $villesproxymite = $em->getRepository('HorusBackendBundle:Villes')->findIdByVilleAndZipcode($ville);
            if (!empty($villesproxymite)) {
                $villesproxymite = $villesproxymite[0];
                $session->set('place', $villesproxymite->getNomVille());
                $administrateur->setVille($villesproxymite->getNomVille());
                $administrateur->setZipcode($villesproxymite->getCodePostal());
                $administrateur->setLongitude($villesproxymite->getLongitude());
                $administrateur->setLatitude($villesproxymite->getLatitude());
            }

            $administrateur->setIp($this->container->get('request')->getClientIp());

            $mdp = $form['password']->getData();

            $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
            $newpass = $encoder->encodePassword($mdp, $administrateur->getSalt());
            $administrateur->setPassword($newpass);

            $em->persist($administrateur);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                "L'administrateur a bien été crée"
            );
            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "L'administrateur  ".$administrateur->getFirstname()." ".$administrateur->getLastname()." vient d'être crée"
            );

            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Creation', 'a crée un administrateur','glyphicon glyphicon-plus');


            return $this->redirect($this->generateUrl('horus_site_administrateurs'));
        }

        return $this->render('HorusBackendBundle:Administrateurs:createadministrateur.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }


    /**
     * Relog a Administrateur
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function relogadministrateurAction($username = null)
    {
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'administrateur a bien été switché avec ".$username
        );

        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Switch', 'a basculé sous un autre administrateur','glyphicon glyphicon-transfer');


        return $this->redirect($this->generateUrl('horus_site_main')."?compte_switch=".$username);
    }


    /**
     * Desactive a Administrateur
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function desactiveadministrateurAction(Administrateur $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setEnabled(false);
        $id->setAccountnonlocked(true);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'administrateur a bien été désactivé"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "L'administrateur  ".$id->getFirstname()." ".$id->getLastname()." vient d'être désactivée"
        );

        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Desactivation', 'a désactivé un administrateur','glyphicon glyphicon-minus-sign');


        return $this->redirect($this->generateUrl('horus_site_administrateurs'));
    }

    /**
     * Active a Administrateur
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activeadministrateurAction(Administrateur $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setEnabled(true);
        $id->setAccountnonlocked(true);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'administrateur a bien été activée"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "L'administrateur  ".$id->getFirstname()." ".$id->getLastname()." vient d'être désactivée"
        );

        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Activation', 'a activé un administrateur','glyphicon glyphicon-plus');


        return $this->redirect($this->generateUrl('horus_site_administrateurs'));
    }


}
