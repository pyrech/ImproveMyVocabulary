<?php

namespace Imv\CoreBundle\Entity;


interface EntityInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get params used in routing
     *
     * @return array
     */
    public function getUrlParams();
} 
