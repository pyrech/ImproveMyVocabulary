<?php

namespace Imv\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Imv\CoreBundle\Entity\Translation;
use Imv\CoreBundle\Entity\Word;

class LoadWordTranslationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $wordlist = $this->getReference('verbes-list');

        $data = array('sleep' => array('fr' => 'dormir',
                                       'en' => 'sleep'),
                      'sing'  => array('fr' => 'chanter',
                                       'en' => 'sing'),
                      'cry'   => array('fr' => 'pleurer',
                                       'en' => 'cry'),
                      'drink' => array('fr' => 'boire',
                                       'en' => 'dring'));

        foreach($data as $details => $translations)
        {
            $word = new Word();
            $word->setDetails($details);
            $manager->persist($word);
            $wordlist->addWord($word);
            foreach($translations as $locale => $term)
            {
                $translation = new Translation();
                $translation->setLocale($this->getReference('locale-'.$locale));
                $translation->setTerm($term);
                $word->addTranslation($translation);
                $manager->persist($translation);
            }
        }
     
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 20;
    }
}
