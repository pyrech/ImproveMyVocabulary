<?php

namespace Imv\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * WordList
 *
 * @ORM\Table(name="wordlist")
 * @ORM\Entity(repositoryClass="Imv\CoreBundle\Entity\WordListRepository")
 */
class WordList
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
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

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
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Imv\CoreBundle\Entity\Word", cascade={"persist"})
     */
    private $words;


    /**
     * Constructor
     */
    public function __construct() {
      $this->count = 0;
      $this->createdAt = new \DateTime();
      $this->public = false;
      $this->updatedAt = new \DateTime();
      $this->words = new ArrayCollection();
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
     * Get the number of words added
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return WordList
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set name
     *
     * @param string $name
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return WordList
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
 
    /**
      * Add word
      *
      * @param Word $word
      */
    public function addWord(Word $word)
    {
        $this->words[] = $word;
        $this->count++;
    }
   
    /**
      * Remove word
      *
      * @param Word $word
      */
    public function removeWord(Word $word)
    {
        $this->words->removeElement($word);
        $this->count--;
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
}
