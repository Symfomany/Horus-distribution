<?php

namespace Horus\BackendBundle\Controller;

use Horus\BackendBundle\Entity\Category;
use Horus\BackendBundle\Entity\Famille;
use Horus\BackendBundle\Entity\ImageCategory;
use Horus\BackendBundle\Form\CategoryType;
use Horus\BackendBundle\Form\FamilleType;
use Horus\BackendBundle\Form\ImageCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CategoryController
 * @package Horus\BackendBundle\Controller
 */
class CategoryController extends Controller
{

    /**
     * All Familles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function famillesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $display = $this->container->get('request')->get('display', 5);

        $familles = $em->getRepository('HorusBackendBundle:Famille')->findBy(array(), array());

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $familles,
            $this->get('request')->query->get('page', 1) /*page number*/,
            $display
        );
        return $this->render('HorusBackendBundle:Category:familles.html.twig', array('familles' => $pagination));
    }

    /**
     * All Categories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $display = $this->container->get('request')->get('display', 5);

        $categories = $em->getRepository('HorusBackendBundle:Category')->findBy(array(), array());

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categories,
            $this->get('request')->query->get('page', 1) /*page number*/,
            $display
        );

        return $this->render('HorusBackendBundle:Category:categories.html.twig', array('categories' => $pagination));
    }


    /**
     * Remove a category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removecategoryAction(Category $id)
    {
        $em = $this->getDoctrine()->getManager();
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "La catégorie ".$id->getName()." vient d'être supprimée"
        );

        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La catégorie a bien été supprimée"
        );

        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Suppression', 'a supprimé une categorie','glyphicon glyphicon-remove');



        return $this->redirect($this->generateUrl('horus_site_categories'));
    }


    /**
     * Remove a family
     * @param Famille $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removefamilleAction(Famille $id)
    {
        $em = $this->getDoctrine()->getManager();
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "La famille ".$id->getName()." vient d'être supprimée"
        );
        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La famille a bien été supprimée"
        );


        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Suppression', 'a supprimé une famille','glyphicon glyphicon-remove');


        return $this->redirect($this->generateUrl('horus_site_familles'));
    }


    /**
     * Create a category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createcategoryAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $idarg = $request->query->get('categoryref');
        if(!empty($idarg)){
            $category = $em->getRepository('HorusBackendBundle:Category')->find($idarg);
        }

        $form = $this->createForm(new CategoryType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "La catégorie a bien été ajoutée"
            );
            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "La catégorie ".$category->getName()." vient d'être crée"
            );

            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Création', 'a crée une categorie','glyphicon glyphicon-plus', $this->generateUrl('horus_site_category', array('id' => $category->getId())));


            return $this->redirect($this->generateUrl('horus_site_edit_image_category', array('id' => $category->getId())));
        }


        return $this->render('HorusBackendBundle:Category:createcategory.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }


    /**
     * Edit a famille
     * @param Famille $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editfamilleAction(Famille $id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new FamilleType(), $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $id->upload();
            $id->setDateCreated(new \Datetime('now'));
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "La famille a bien été modifiée"
            );
            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "La famille ".$id->getName()." vient d'être modifiée"
            );

            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Edition', 'a edité une famille','glyphicon glyphicon-pencil',  $this->generateUrl('horus_site_famille', array('id' => $id->getId())));


            return $this->redirect($this->generateUrl('horus_site_familles'));
        }

        return $this->render('HorusBackendBundle:Category:editfamille.html.twig',
            array(
                'form' => $form->createView(),
                'famille' => $id,
            )
        );
    }

    /**
     * Create a famille
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createfamilleAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $famille = new Famille();
        $idarg = $request->query->get('familleref');
        if(!empty($idarg)){
            $famille = $em->getRepository('HorusBackendBundle:Famille')->find($idarg);
        }
        $form = $this->createForm(new FamilleType(), $famille);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $famille->upload();
            $em->persist($famille);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "La famille a bien été ajoutée"
            );
            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "La famille ".$famille->getName()." vient d'être crée"
            );
            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Création', 'a crée une famille','glyphicon glyphicon-plus',  $this->generateUrl('horus_site_famille', array('id' => $famille->getId())));


            return $this->redirect($this->generateUrl('horus_site_familles'));
        }

        return $this->render('HorusBackendBundle:Category:createfamille.html.twig',
            array(
                'form' => $form->createView(),
            )
        );

    }

    /**
     * Cover a image of category
     * @param ImageCategory $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function coverimagecategoryAction(ImageCategory $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $id->getCategory();

        /**
         * HAndle old images
         */
        $oldsimage = $category->getImages();
        if (!empty($oldsimage))
            foreach ($oldsimage as $img) {
                $img->setCover(false);
                $em->persist($img);
                $em->flush();
            }
        $id->setCover(true);
        $em->persist($id);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            "L'image de la catégorie a bien été mise en avant"
        );

        $this->container->get('lastactions_listener')->insertActions('Image', 'a mis une image en avant','glyphicon glyphicon-picture',  'horus_site_edit_image_category', array('id' => $id->getCategory()->getId()));


        return $this->redirect($this->generateUrl('horus_site_edit_image_category', array('id' => $id->getCategory()->getId())));
    }

    /**
     * Remove a image of category
     * @param ImageCategory $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeimagecategoryAction(ImageCategory $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'image de la catégories a bien été activé"
        );

        $this->container->get('lastactions_listener')->insertActions('Image', 'a supprimé une image','glyphicon glyphicon-picture',  'horus_site_edit_image_category', array('id' => $id->getCategory()->getId()));


        return $this->redirect($this->generateUrl('horus_site_edit_image_category', array('id' => $id->getCategory()->getId())));
    }

    /**
     * Desactive a category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function desactivecategoryAction(Category $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setVisible(false);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La catégory a bien été désactivé"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "La catégory ".$id->getName()." vient d'être désactivée"
        );
        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Désactivation', 'a désactivé une categorie','glyphicon glyphicon-minus-sign', $this->generateUrl('horus_site_category', array('id' => $id->getId())));


        return $this->redirect($this->generateUrl('horus_site_categories'));
    }

    /**
     * Active a Category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activecategoryAction(Category $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setVisible(true);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La category a bien été activée"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "La catégory ".$id->getName()." vient d'être activée"
        );

        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Activation', 'a activé une catégorie','glyphicon glyphicon-check',$this->generateUrl('horus_site_category', array('id' => $id->getId())));


        return $this->redirect($this->generateUrl('horus_site_categories'));
    }

    /**
     * Desactive a category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function desactivefamilleAction(Famille $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setVisible(false);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La famille a bien été désactivé"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "La famille ".$id->getName()." vient d'être désactivée"
        );
        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Désactivation', 'a désactivé une famille','glyphicon glyphicon-minus-sign', $this->generateUrl('horus_site_famille', array('id' => $id->getId())));


        return $this->redirect($this->generateUrl('horus_site_familles'));
    }

    /**
     * Active a Category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activefamilleAction(Famille $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setVisible(true);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La famille a bien été activée"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "La famille ".$id->getName()." vient d'être activée"
        );

        /**
         * Notifications
         */
        $this->container->get('lastactions_listener')->insertActions('Activation', 'a activé une famille','glyphicon glyphicon-check',$this->generateUrl('horus_site_famille', array('id' => $id->getId())));


        return $this->redirect($this->generateUrl('horus_site_familles'));
    }

    /**
     * Get a Category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction(Category $id)
    {
        $produits = $id->getProduits();
        $articles = $id->getArticles();
        return $this->render('HorusBackendBundle:Category:category.html.twig',
            array(
                'category' => $id,
                'produits' => $produits,
                'articles' => $articles
            )
        );
    }


    /**
     * Get a famille
     * @param Famille $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function familleAction(Famille $id)
    {
        $produits = $id->getProduits();
        return $this->render('HorusBackendBundle:Category:famille.html.twig',
            array(
                'category' => $id,
                'produits' => $produits
            )
        );
    }

    /**
     * Get a picture of category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function picturecategoryAction(Category $id)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $image = new ImageCategory();
        $image->setCategory($id);
        $form = $this->createForm(new ImageCategoryType(), $image);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $isfirst = $em->getRepository('HorusBackendBundle:ImageCategory')->isFirstImage($id);
            if ((int)$isfirst['nombre'] == 0)
                $image->setCover(true);

            $image->upload($id->getId());
            $em->persist($image);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "L'image de la catégory a bien été ajouté"
            );
            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Image', 'a ajouté une image dans un catégorie','glyphicon glyphicon-picture', $this->generateUrl('horus_site_category', array('id' => $id->getId())));


            return new JsonResponse(true);
        }

        return $this->render('HorusBackendBundle:Category:picturecategory.html.twig',
            array(
                'form' => $form->createView(),
                'category' => $id,
            )
        );
    }


    /**
     * Edit a category
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editcategoryAction(Category $id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new CategoryType(), $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $id->setDateUpdated(new \Datetime('now'));
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "La catégory a bien été editée"
            );
            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "La catégory ".$id->getName()." vient d'être editée"
            );
            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Edition', 'a edité une categorie','glyphicon glyphicon-pencil',$this->generateUrl('horus_site_category', array('id' => $id->getId())));


            return $this->redirect($this->generateUrl('horus_site_categories'));
        }

        return $this->render('HorusBackendBundle:Category:editcategory.html.twig',
            array(
                'form' => $form->createView(),
                'category' => $id,
            )
        );

    }


}
