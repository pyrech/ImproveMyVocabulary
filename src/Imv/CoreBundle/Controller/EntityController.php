<?php

namespace Imv\CoreBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


abstract class EntityController extends Controller
{
    /**
     * @var string
     */
    private $repositoryName;

    /**
     * Initialize the $repositoryName attribute
     */
    function __construct()
    {
        $this->repositoryName = $this->getRepositoryName();
    }

    /**
     * Returns the Doctrine Manager
     *
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Returns the Entity repository
     *
     * @return \Imv\CoreBundle\Entity\WordRepository
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository($this->repositoryName);
    }

    /**
     * Returns repository's name of the related entity
     *
     * @return string
     */
    abstract protected function getRepositoryName();

} 
