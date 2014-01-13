<?php

namespace Imv\CoreBundle\Tests\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Imv\CoreBundle\Entity\EntityInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestEntity extends WebTestCase
{
    /**
     * @var EntityManager
     */
    protected $_em;

    /**
     * @var string
     */
    private $repositoryName;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $kernel = static::createKernel();
        $this->_em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->_em->beginTransaction();
        $this->repositoryName = $this->getRepositoryName();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->_em->rollback();
        parent::tearDown();
    }

    /**
     * Return the repository name for the associated entity.
     *
     * @return string
     */
    abstract protected function getRepositoryName();

    /**
     * Return a repository for the name given.
     *
     * If not repository name was given, it uses the repository of the entity associated
     *
     * @param string $repositoryName
     *
     * @return EntityRepository
     */
    protected function getRepository($repositoryName="")
    {
        if(empty($repositoryName)) {
            $repositoryName = $this->repositoryName;
        }
        return $this->_em->getRepository($repositoryName);
    }

    /**
     * Find an entity in the database
     *
     * @param $id
     * @param string $repositoryName
     *
     * @return null|EntityInterface
     */
    protected function findEntity($id, $repositoryName="")
    {
        return $this->getRepository($repositoryName)->find($id);
    }

    /**
     * Reload an entity from the database
     *
     * @param EntityInterface $entity
     *
     * @return null|EntityInterface
     */
    protected function reload(EntityInterface $entity)
    {
        return $this->getRepository()->find($entity->getId());
    }

    /**
     * Return a unique string
     *
     * @param string $prefix default is 'str_'
     *
     * @return string
     */
    protected function getUniqueString($prefix='str_')
    {
        return uniqid($prefix);
    }
} 
