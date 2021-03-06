<?php

namespace Imv\CoreBundle\Tests\Entity;

use Imv\CoreBundle\Entity\Word;
use Imv\CoreBundle\Entity\WordList;

class WordListTest extends AbstractTestEntity
{
    /**
     * @inheritdoc
     */
    protected function getRepositoryName()
    {
        return 'ImvCoreBundle:WordList';
    }

    public function testScalarGettersAndSetters()
    {
        $listName = $this->getUniqueString();

        $entity = new WordList();
        $this->_em->persist($entity);

        $entity->setName($listName);
        $this->_em->flush();

        // Reload the entity
        $entity = $this->reload($entity);

        // Test Name field
        $this->assertEquals($listName, $entity->getName(), 'Invalid wordlist name');
    }

    public function testNullNameThrowsException()
    {
        $this->setExpectedException('\\Doctrine\\DBAL\\DBALException');

        $entity = new WordList();
        $this->_em->persist($entity);

        $this->_em->flush(); // Should throw an exception as the name cannot be null
    }

    public function testAddWord()
    {
        $entity = new WordList();
        $entity->setName($this->getUniqueString());
        $this->_em->persist($entity);

        $words = array();
        for($i=0; $i<2; $i++) {
            $word = new Word();
            $word->setDetails($this->getUniqueString());
            $entity->addWord($word);
            $words[] = $word;
        }
        $this->_em->flush();

        // Reload the entity
        $entity = $this->reload($entity);

        // Test the number of word associated
        $this->assertEquals(2, $entity->getCount(), 'Invalid wordlist count');
        $this->assertEquals(2, $entity->getWords()->count(), 'Invalid number of word');
    }

    public function testFindWord()
    {
        $entity = new WordList();
        $entity->setName($this->getUniqueString());
        $this->_em->persist($entity);

        $word = new Word();
        $wordDetails = $this->getUniqueString();
        $word->setDetails($wordDetails);
        $entity->addWord($word);
        $this->_em->flush();

        // Reload the entity
        $entity = $this->reload($entity);

        // Check a word is findable in a wordlist
        $found = false;
        foreach($entity->getWords() as $w) {
            if ($w->getDetails() == $wordDetails) {
                $found = true;
            }
        }
        $this->assertTrue($found, 'New word added not found');
    }

    public function testRemoveWord()
    {
        $entity = new WordList();
        $entity->setName($this->getUniqueString());
        $this->_em->persist($entity);

        $word = new Word();
        $wordDetails = $this->getUniqueString();
        $word->setDetails($wordDetails);
        $entity->addWord($word);
        $this->_em->flush();

        // Test the number of word associated
        $this->assertEquals(1, $entity->getCount(), 'Invalid wordlist count');

        $entity->removeWord($word);
        $this->_em->flush();

        // Reload the entity
        $entity = $this->reload($entity);

        // Test the number of word associated
        $this->assertEquals(0, $entity->getCount(), 'Invalid wordlist count');
        $this->assertEquals(0, $entity->getWords()->count(), 'Invalid number of word');

        // Check a word is not findable in a wordlist after being removed
        $found = false;
        foreach($entity->getWords() as $w) {
            if ($w->getDetails() == $wordDetails) {
                $found = true;
            }
        }
        $this->assertFalse($found, 'Word removed found');
    }

    public function testDeleteWord()
    {
        $entity = new WordList();
        $entity->setName($this->getUniqueString());
        $this->_em->persist($entity);

        $word = new Word();
        $word->setDetails($this->getUniqueString());
        $entity->addWord($word);
        $this->_em->flush();

        // Test the number of word associated
        $this->assertEquals(1, $entity->getCount(), 'Invalid wordlist count');

        $this->_em->remove($word);
        $this->_em->flush();

        // Reload the entity
        $entity = $this->reload($entity);

        // Test the number of word associated
        $this->assertEquals(0, $entity->getCount(), 'Invalid wordlist count');
    }
}
