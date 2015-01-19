<?php

namespace Mon\QcmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParticipationAnswer
 *
 * @ORM\Table("participations_answers")
 * @ORM\Entity(repositoryClass="Mon\QcmBundle\Entity\ParticipationAnswerRepository")
 */
class ParticipationAnswer
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
     * @var Participation
     *
     * @ORM\ManyToOne(targetEntity="Participation", inversedBy="answers")
     * @ORM\JoinColumn(name="participation_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $participation;

    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $question;

    /**
     * @var array
     *
     * @ORM\Column(name="answer", type="json_array")
     */
    private $answer;

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
     * Set answer
     *
     * @param array $answer
     * @return ParticipationAnswer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return array 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @return Participation
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * @param Participation $participation
     *
     * @return $this
     */
    public function setParticipation($participation)
    {
        $this->participation = $participation;

        return $this;
    }

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param Question $question
     *
     * @return $this
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    // endregion

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
    }
}
