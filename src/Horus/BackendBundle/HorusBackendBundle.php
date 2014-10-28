<?php

namespace Horus\BackendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class HorusBackendBundle
 * @package Horus\BackendBundle
 */
class HorusBackendBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
