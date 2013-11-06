<?php

namespace Imv\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ImvUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
