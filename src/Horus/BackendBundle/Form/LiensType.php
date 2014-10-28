<?php

namespace Horus\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LiensType
 * @package Horus\BackendBundle\Form
 */
class LiensType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('link', 'text', array('label' => "Lien",'required' => false,'attr' => array( 'placeholder' => 'Url du lien')))
                ->add('aliasing', 'text', array('label' => "Titre du lien",'required' => false,'attr' => array('class' => 'form-control','cols' => 100, 'rows' => 6,'placeholder' => 'Titre du lien')));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lien';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(array(
            'data_class' => 'Horus\BackendBundle\Entity\Liens',
            'csrf_protection' => false
        ));
    }
}
