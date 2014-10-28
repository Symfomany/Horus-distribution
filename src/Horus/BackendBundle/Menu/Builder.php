<?php

namespace Horus\BackendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class Builder
 * @package Horus\BackendBundle\Menu
 */
class Builder extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'horus_site_hello'));
        $menu->addChild('Dashboard', array('route' => 'horus_site_dashboard' ));
        $menu->addChild('Contact', array('route' => 'horus_contact' ));
        $menu->addChild('Rechercher', array('route' => 'horus_search' ));

        return $menu;
    }
}