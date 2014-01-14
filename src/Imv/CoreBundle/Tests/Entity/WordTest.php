<?php

namespace Imv\CoreBundle\Tests\Entity;

use Imv\CoreBundle\Entity\Translation;
use Imv\CoreBundle\Entity\Word;
use Imv\CoreBundle\Entity\WordList;

class WordTest extends AbstractTestEntity
{
    /**
     * @inheritdoc
     */
    protected function getRepositoryName()
    {
        return 'ImvCoreBundle:Word';
    }

    public function testScalarGettersAndSetters()
    {
        $wordDetails = $this->getUniqueString();

        $entity = new Word();
        $this->_em->persist($entity);

        $entity->setDetails($wordDetails);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->reload($entity->getId());

        // Test Details field
        $this->assertEquals($wordDetails, $entity->getDetails(), 'Invalid word details');
    }

    public function testNullDetailsThrowsException()
    {
        $this->setExpectedException('\\Doctrine\\DBAL\\DBALException');

        $entity = new Word();
        $this->_em->persist($entity);

        $this->_em->flush(); // Should throw an exception as the details cannot be null
    }

    public function testAddWordList()
    {
        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $wordlists = array();
        for($i=0; $i<2; $i++) {
            $wordlist = new WordList();
            $wordlist->setName($this->getUniqueString());
            $entity->addWordList($wordlist);
            $wordlists[] = $wordlist;
        }
        $this->_em->persist($entity);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->findEntity($entity->getId());

        // Test the number of wordlist associated
        $this->assertEquals(2, $entity->getWordLists()->count(), 'Invalid number of wordlist');
    }

    public function testFindWordList()
    {
        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $wordlist = new WordList();
        $wordlistName = $this->getUniqueString();
        $wordlist->setName($wordlistName);
        $entity->addWordList($wordlist);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->findEntity($entity->getId());

        // Check a wordlist is findable in a word
        $found = false;
        foreach($entity->getWordLists() as $wl) {
            if ($wl->getName() == $wordlistName) {
                $found = true;
            }
        }
        $this->assertTrue($found, 'New wordlist added not found');
    }

    public function testRemoveWordList()
    {
        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $wordlist = new WordList();
        $wordlistName = $this->getUniqueString();
        $wordlist->setName($wordlistName);
        $entity->addWordList($wordlist);
        $this->_em->flush();

        // Test the number of word associated
        $this->assertEquals(1, $entity->getWordLists()->count(), 'Invalid number of wordlist');

        $entity->removeWordList($wordlist);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->findEntity($entity->getId());

        // Test the number of word associated
        $this->assertEquals(0, $entity->getWordLists()->count(), 'Invalid number of wordlist');

        // Check a wordlist is not findable in a word after being removed
        $found = false;
        foreach($entity->getWordLists() as $wl) {
            if ($wl->getName() == $wordlistName) {
                $found = true;
            }
        }
        $this->assertFalse($found, 'WordList removed found');
    }

    public function testDeleteWordList()
    {
        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $wordlist = new WordList();
        $wordlist->setName($this->getUniqueString());
        $entity->addWordList($wordlist);
        $this->_em->flush();

        // Test the number of wordlist associated
        $this->assertEquals(1, $entity->getWordLists()->count(), 'Invalid number of wordlist');

        $this->_em->remove($wordlist);
        $this->_em->flush();

        // Test the number of wordlist associated
        $this->assertEquals(0, $entity->getWordLists()->count(), 'Invalid number of wordlist');
    }

    public function testAddTranslation()
    {
        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $translations = array();
        for($i=0; $i<2; $i++) {
            $translation = new Translation();
            $translation->setTerm($this->getUniqueString());
            $entity->addTranslation($translation);
            $translations[] = $translation;
        }
        $this->_em->persist($entity);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->findEntity($entity->getId());

        // Test the number of wordlist associated
        $this->assertEquals(2, $entity->getTranslations()->count(), 'Invalid number of translation');
    }

    public function testFindTranslation()
    {
        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $translation = new Translation();
        $translationTerm = $this->getUniqueString();
        $translation->setTerm($translationTerm);
        $entity->addTranslation($translation);
        $this->_em->flush();

        // Reload the entity
        //$entity = $this->findEntity($entity->getId());

        // Check a translation is findable in a word
        $found = false;
        foreach($entity->getTranslations() as $t) {
            if ($t->getTerm() == $translationTerm) {
                $found = true;
            }
        }
        $this->assertTrue($found, 'New translation added not found');
    }

    public function testRemoveTranslationThrowsException()
    {
        $this->setExpectedException('\\Doctrine\\DBAL\\DBALException');

        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $translation = new Translation();
        $translation->setTerm($this->getUniqueString());
        $entity->addTranslation($translation);
        $this->_em->flush();

        // Test the number of word associated
        $this->assertEquals(1, $entity->getTranslations()->count(), 'Invalid number of translation');

        $entity->removeTranslation($translation);
        $this->_em->flush(); // Should throw an exception as a translation cannot be linked to none word
    }

    public function testDeleteTranslation()
    {
        $entity = new Word();
        $entity->setDetails($this->getUniqueString());
        $this->_em->persist($entity);

        $translation = new Translation();
        $translation->setTerm($this->getUniqueString());
        $entity->addTranslation($translation);
        $this->_em->flush();

        // Test the number of translation associated
        $this->assertEquals(1, $entity->getTranslations()->count(), 'Invalid number of translation');

        $this->_em->remove($translation);
        $this->_em->flush();

        // Test the number of translation associated
        $this->assertEquals(0, $entity->getTranslations()->count(), 'Invalid number of translation');
    }
}
