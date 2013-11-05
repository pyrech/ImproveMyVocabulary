<?php

namespace Img\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Imv\CoreBundle\Entity\Locale;

class LoadLocaleData extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = array('fr' => 'french',
                      'en' => 'english');

        //$locales = new ArrayCollection();
        //$locales = array();

        foreach($data as $code => $name)
        {
            $locale = new Locale();
            $locale->setName($name);
            $locale->setCode($code);
            $manager->persist($locale);
            $this->addReference('locale-'.$locale->getCode(), $locale);
            //$locales->set($locale->getCode(), $locale);
            //$locales[$locale->getCode()] = $locale;
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
} 