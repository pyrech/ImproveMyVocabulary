<?php

namespace Imv\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translation of a Word in a specific language
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Translation implements EntityInterface
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
     * @ORM\Column(name="term", type="text")
     */
    private $term;

    /**
     * @var Locale
     *
     * @ORM\ManyToOne(targetEntity="Imv\CoreBundle\Entity\Locale", cascade={"persist"})
     */
    private $locale;

    /**
     * @var Word
     *
     * @ORM\ManyToOne(targetEntity="Imv\CoreBundle\Entity\Word", inversedBy="translations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $word;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     *
     * @throws Exception This entity cannot be used in url
     */
    public function getUrlParams()
    {
        throw new \Exception('Unsupported operation');
    }

    /**
     * Set term
     *
     * @param string $term
     *
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
     *
     * @return Translation
     */
    public function setLocale(Locale $locale)
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
     * @param boolean $cascade
     *
     * @return Translation
     */
    public function setWord(Word $word, $cascade=true)
    {
        $this->word = $word;
        if ($cascade) {
            $word->addTranslation($this, false);
        }
        return $this;
    }

    /**
     * Unset word
     *
     * @param boolean $cascade
     *
     * @return Translation
     */
    public function removeWord($cascade=true)
    {
        $word = $this->word;
        if ($word) {
            $this->word = null;
            if ($cascade) {
                $word->removeTranslation($this, false);
            }
        }
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

    /**
     * Do stuff when a translation is removed
     *
     * @ORM\PreRemove
     */
    public function onPreRemove()
    {
        $this->removeWord();
    }
}
