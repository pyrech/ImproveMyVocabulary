<?php

namespace Imv\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imv\CoreBundle\Entity\WordRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Word implements EntityInterface
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Imv\CoreBundle\Entity\Translation", mappedBy="word", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Imv\CoreBundle\Entity\WordList", mappedBy="words", cascade={"persist"})
     */
    private $wordlists;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->wordlists = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getUrlParams()
    {
        return array('id' => $this->getId());
    }

    /**
     * Set details
     *
     * @param string $details
     *
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
     * @param boolean $cascade
     *
     * @return Word
     */
    public function addTranslation(Translation $translation, $cascade=true)
    {
        $this->translations[] = $translation;
        if ($cascade) {
            $translation->setWord($this, false);
        }
        return $this;
    }

    /**
     * Remove a translation
     *
     * @param Translation $translation
     * @param boolean $cascade
     *
     * @return Word
     */
    public function removeTranslation(Translation $translation, $cascade=true)
    {
        $this->translations->removeElement($translation);
        if ($cascade) {
            $translation->removeWord(false);
        }
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

    /**
     * Get the translation for a given locale
     *
     * @param Locale $locale
     *
     * @return Translation
     */
    public function getTranslation(Locale $locale)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }
    }

    /**
     * Add wordList
     *
     * @param WordList $wordlist
     * @param boolean $cascade
     */
    public function addWordList(WordList $wordlist, $cascade=true)
    {
        $this->wordlists[] = $wordlist;
        if ($cascade) {
            $wordlist->addWord($this, false);
        }
    }

    /**
     * Remove wordlist
     *
     * @param WordList $wordlist
     * @param boolean $cascade
     */
    public function removeWordList(WordList $wordlist, $cascade=true)
    {
        $this->wordlists->removeElement($wordlist);
        if ($cascade) {
            $wordlist->removeWord($this, false);
        }
    }

    /**
     * Get wordlists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWordLists()
    {
        return $this->wordlists;
    }

    /**
     * Do stuff when a word is removed
     *
     * @ORM\PreRemove
     */
    public function onPreRemove()
    {
        foreach($this->wordlists as $wordlist) {
            $this->removeWordList($wordlist);
        }
    }
}
