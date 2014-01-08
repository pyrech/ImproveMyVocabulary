<?php

namespace Imv\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * WordList
 *
 * @ORM\Table(name="wordlist")
 * @ORM\Entity(repositoryClass="Imv\CoreBundle\Entity\WordListRepository")
 * @ORM\HasLifecycleCallbacks
 */
class WordList implements EntityInterface
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
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Imv\CoreBundle\Entity\Word", inversedBy="wordlists", cascade={"persist"})
     */
    private $words;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->count = 0;
        $this->public = false;
        $this->words = new ArrayCollection();
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
     * Get the number of words added
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return WordList
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return WordList
     */
    public function setPublic($public = true)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function isPublic()
    {
        return $this->public;
    }
 
    /**
      * Add word
      *
      * @param Word $word
      * @param boolean $cascade
      */
    public function addWord(Word $word, $cascade=true)
    {
        $this->count++;
        $this->words[] = $word;
        if ($cascade) {
            $word->addWordList($this, false);
        }
    }
   
    /**
      * Remove word
      *
      * @param Word $word
      * @param boolean $cascade
      */
    public function removeWord(Word $word, $cascade=true)
    {
        $this->count--;
        $this->words->removeElement($word);
        if ($cascade) {
            $word->removeWordList($this, false);
        }
    }
   
    /**
      * Get words
      *
      * @return \Doctrine\Common\Collections\Collection
      */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Do stuff when a wordlist is removed
     *
     * @ORM\PreRemove
     */
    public function onPreRemove()
    {
        foreach($this->words as $word) {
            $this->removeWord($word);
        }
    }
}
