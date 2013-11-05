<?php

namespace Imv\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translation of a Word in a specific language
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Translation
{
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
     * @ORM\Column(name="term", type="text")
     */
    private $term;

    /**
     * @var Locale
     *
     * @ORM\ManyToOne(targetEntity="Imv\CoreBundle\Entity\Locale", inversedBy="word", cascade={"persist"})
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity="Imv\CoreBundle\Entity\Word", inversedBy="translations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $word;

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
     * Set term
     *
     * @param string $term
     * @return Translation
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set the locale for the current translation
     *
     * @param Locale $locale
     * @return Translation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Get the locale of the current translation
     *
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set word
     *
     * @param Word $word
     * @return Translation
     */
    public function setWord($word)
    {
        $this->word = $word;
        return $this;
    }

    /**
     * Get word
     *
     * @return Word
     */
    public function getWord()
    {
        return $this->word;
    }
}
