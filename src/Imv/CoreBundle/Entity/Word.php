<?php

namespace Imv\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="Imv\CoreBundle\Entity\WordRepository")
 */
class Word
{
    use Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=255)
     */
    private $details;

    /**
     * @ORM\OneToMany(targetEntity="Imv\CoreBundle\Entity\Translation", mappedBy="word", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return Word
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Add a translation
     *
     * @param Translation $translation
     * @return Word
     */
    public function addTranslation(Translation $translation)
    {
        $this->translations[] = $translation;
        $translation->setWord($this);
        return $this;
    }

    /**
     * Remove a translation
     *
     * @param Translation $translation
     * @return Word
     */
    public function removeTranslation(Translation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
