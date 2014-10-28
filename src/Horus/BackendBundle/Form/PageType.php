<?php

namespace Horus\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PageType
 * @package Horus\BackendBundle\Form
 */
class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array('attr' => array('placeholder' => 'Titre de la page')))
                ->add('cover', 'textarea', array('attr' => array("class" => "ckeditor", 'placeholder' => 'Résumé en quelques mots')))
                ->add('chapeau', 'textarea', array('attr' => array("class" => "ckeditor", 'placeholder' => 'Chapeau du texte')))
                ->add('video', 'text', array('required' => false, 'attr' => array( 'placeholder' => "Ex:  http://www.youtube.com/watch?v=BQjqM24uWr8")))
                ->add('description', 'textarea', array('attr' => array("class" => "ckeditor", 'placeholder' => 'Description complète')))
                ->add('nature','choice', array(
                    'choices'   => array(1 => 'Brouillon', 2 => 'En attente de relecture', 3 => 'Final'),
                    'required'  => true,
                    'expanded' => true
                ))
                ->add('parent', 'entity', array(
                    'label' => 'Page parente',
                    'class' => 'HorusBackendBundle:Page',
                    'property' => 'OptionLabel',
                    'required' => false,
                    'empty_value' => 'Choisissez une page parente'
                ))
                ->add('file')
                ->add('articles')
                ->add('produits');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(array(
            'data_class' => 'Horus\BackendBundle\Entity\Page',
            'csrf_protection' => false
        ));
    }
}
