<?php

namespace Mon\QcmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Qcm
 *
 * @ORM\Table("qcms")
 * @ORM\Entity(repositoryClass="Mon\QcmBundle\Entity\Repository\QcmRepository")
 *
 * @UniqueEntity("slug")
 */
class Qcm
{
    // region Properties

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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="255")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min="4")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="qcm", cascade={"persist"})
     *
     * @Assert\Count(min="1")
     * @Assert\Valid()
     */
    private $questions;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Participation", mappedBy="qcm")
     */
    private $participations;

    // endregion

    // region Getters/Setters

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
     * Set title
     *
     * @param string $title
     * @return Qcm
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Qcm
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Qcm
     */
    public function setCreatedAt($createdAt)
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Qcm
     */
    public function setUpdatedAt($updatedAt)
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
     * @return Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Question $question
     * @return $this
     */
    public function addQuestion(Question $question)
    {
        $this->questions->add($question);

        $question->setQcm($this);

        return $this;
    }

    /**
     * @param Question $question
     * @return $this
     */
    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getParticipations()
    {
        return $this->participations;
    }

    /**
     * @param Participation $participation
     * @return $this
     */
    public function addParticipation(Participation $participation)
    {
        $this->participations->add($participation);
        $participation->setQcm($this);

        return $this;
    }

    /**
     * @param Participation $participation
     * @return $this
     */
    public function removeParticipation(Participation $participation)
    {
        $this->participations->removeElement($participation);

        return $this;
    }

    // endregion

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    public function reindexPosition()
    {
        $questionPosition = 0;
        foreach ($this->questions as $question) {
            /** @var Question $question */
            $question->setPosition($questionPosition++);

            $answerPosition = 0;
            foreach ($question->getPropositions() as $proposition) {
                /** @var AnswerProposition $proposition */
                $proposition->setPosition($answerPosition++);
            }
        }
    }
}
