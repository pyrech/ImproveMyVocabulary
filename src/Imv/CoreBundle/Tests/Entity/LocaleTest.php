<?php

namespace Imv\CoreBundle\Tests\Entity;


use Imv\CoreBundle\Entity\Locale;

class LocaleTest extends AbstractTestEntity
{
    /**
     * @inheritdoc
     */
    protected function getRepositoryName()
    {
        return 'ImvCoreBundle:Locale';
    }

    public function testScalarGettersAndSetters()
    {
        $localeName = $this->getUniqueString();
        $localeCode = $this->getUniqueString();

        $entity = new Locale();
        $this->_em->persist($entity);

        $entity->setName($localeName);
        $entity->setCode($localeCode);
        $this->_em->flush();

        // Reload the entity
        $entity = $this->reload($entity);

        // Test Name & Code fields
        $this->assertEquals($localeName, $entity->getName(), 'Invalid locale name');
        $this->assertEquals($localeCode, $entity->getCode(), 'Invalid locale code');
    }

    public function testNullNameThrowsException()
    {
        $this->setExpectedException('\\Doctrine\\DBAL\\DBALException');

        $entity = new Locale();
        $entity->setCode($this->getUniqueString());
        $this->_em->persist($entity);

        $this->_em->flush(); // Should throw an exception as the name cannot be null
    }

    public function testNullCodeThrowsException()
    {
        $this->setExpectedException('\\Doctrine\\DBAL\\DBALException');

        $entity = new Locale();
        $entity->setName($this->getUniqueString());
        $this->_em->persist($entity);

        $this->_em->flush(); // Should throw an exception as the code cannot be null
    }
}
