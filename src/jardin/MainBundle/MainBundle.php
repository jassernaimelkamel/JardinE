<?php

namespace jardin\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
