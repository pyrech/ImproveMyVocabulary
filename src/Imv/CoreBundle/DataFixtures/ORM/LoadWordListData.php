<?php

namespace Imv\CoreBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
 
class LoadWordListData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $names = array('verbes', 'sports', 'histoire', 'cuisine');
        $wordlists = array();
        foreach($names as $i => $name)
        {
            $wordlists[$i] = new \Imv\CoreBundle\Entity\WordList();
            $wordlists[$i]->setName($name);
            $wordlists[$i]->setPublic();
            $manager->persist($wordlists[$i]);
        }
     
        $manager->flush();
        $this->addReference('verbes-list', $wordlists[0]);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
