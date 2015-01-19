<?php

namespace Mon\QcmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Question
 *
 * @ORM\Table("qcms_questions")
 * @ORM\Entity(repositoryClass="Mon\QcmBundle\Entity\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="sentence", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="255")
     */
    private $sentence;

    /**
     * @var string
     *
     * @ORM\Column(name="explanation", type="text", nullable=true)
     */
    private $explanation;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

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
     * @var Qcm
     *
     * @ORM\ManyToOne(targetEntity="Qcm", inversedBy="questions", cascade={"persist"})
     * @ORM\JoinColumn(name="qcm_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $qcm;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AnswerProposition",
     *      mappedBy="question", cascade={"persist"})
     *
     * @Assert\Count(min="2")
     * @Assert\Valid()
     */
    private $propositions;

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
     * Set sentence
     *
     * @param string $sentence
     * @return Question
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;

        return $this;
    }

    /**
     * Get sentence
     *
     * @return string 
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set explanation
     *
     * @param string $explanation
     * @return Question
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * Get explanation
     *
     * @return string 
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Question
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
     * @return Question
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
     * @return Qcm
     */
    public function getQcm()
    {
        return $this->qcm;
    }

    /**
     * @param Qcm $qcm
     *
     * @return $this
     */
    public function setQcm($qcm)
    {
        $this->qcm = $qcm;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPropositions()
    {
        return $this->propositions;
    }

    public function addProposition(AnswerProposition $proposition)
    {
        $this->propositions->add($proposition);

        $proposition->setQuestion($this);

        return $this;
    }

    public function removeProposition(AnswerProposition $proposition)
    {
        $this->propositions->removeElement($proposition);

        return $this;
    }

    // endregion

    public function __construct()
    {
        $this->propositions = new ArrayCollection();
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     *
     * @param ExecutionContextInterface $context
     * @Assert\Callback()
     */
    public function validatePropositions(ExecutionContextInterface $context)
    {
        $countCorrect = 0;
        $countBad = 0;

        foreach ($this->propositions as $proposition) {
            /** @var AnswerProposition $proposition */

            if ($proposition->isIsCorrect()) {
                $countCorrect++;
            }
            else {
                $countBad++;
            }

            if ($countCorrect > 0 && $countBad > 0) {
                break;
            }
        }

        if ($countCorrect == 0) {
            $context
                ->buildViolation('At least one valid answer must be defined for the question')
                ->atPath('propositions')
                ->addViolation();
        }

        if ($countBad == 0) {
            $context
                ->buildViolation('At least one false answer must be defined for the question')
                ->atPath('propositions')
                ->addViolation();
        }
    }
}
