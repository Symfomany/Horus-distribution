<?php

namespace Horus\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SearchType
 * @package Horus\BackendBundle\Form
 */
class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', 'text', array('required' => true,'attr' => array('placeholder' => 'Mots-clefs: Nom, Référence, Description, Catégorie...')));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'search';
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }
}
