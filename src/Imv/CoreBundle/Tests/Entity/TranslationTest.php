<?php

namespace Imv\CoreBundle\Tests\Entity;


use Imv\CoreBundle\Entity\Locale;
use Imv\CoreBundle\Entity\Translation;
use Imv\CoreBundle\Entity\Word;

class TranslationTest extends AbstractTestEntity {

    /**
     * @inheritdoc
     */
    protected function getRepositoryName()
    {
        return 'ImvCoreBundle:Translation';
    }

    public function testScalarGettersAndSetters()
    {
        $translationTerm = $this->getUniqueString();

        $entity = new Translation();
        $this->_em->persist($entity);

        $entity->setTerm($translationTerm);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->reload($entity->getId());

        // Test Details field
        $this->assertEquals($translationTerm, $entity->getTerm(), 'Invalid translation term');
    }

    public function testWordGetterAndSetter()
    {
        $entity = new Translation();
        $entity->setTerm($this->getUniqueString());
        $this->_em->persist($entity);

        $word = new Word();
        $word->setDetails($this->getUniqueString());
        $entity->setWord($word);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->findEntity($entity->getId());

        // Test the word associated
        $this->assertEquals($word, $entity->getWord(), 'Invalid word');
    }

    public function testRemoveWordThrowException()
    {
        $this->setExpectedException('\\Doctrine\\DBAL\\DBALException');

        $entity = new Translation();
        $translationTerm = $this->getUniqueString();
        $entity->setTerm($translationTerm);
        $this->_em->persist($entity);

        $word = new Word();
        $word->setDetails($this->getUniqueString());

        $entity->setWord($word);
        $this->_em->flush();

        // Test the word associated
        $this->assertEquals($word, $entity->getWord(), 'Invalid word');

        $entity->removeWord();
        $this->_em->flush(); // Should throw an exception as a translation cannot be linked to none word
    }

    public function testLocaleGetterAndSetter()
    {
        $entity = new Translation();
        $entity->setTerm($this->getUniqueString());
        $this->_em->persist($entity);

        $word = new Word();
        $word->setDetails($this->getUniqueString());
        $entity->setWord($word);

        $locale = new Locale();
        $entity->setLocale($locale);

        $this->_em->flush();

        // Reload the entity
        //$entity = $this->findEntity($entity->getId());

        // Test the word associated
        $this->assertEquals($locale, $entity->getLocale(), 'Invalid locale');
    }
}

