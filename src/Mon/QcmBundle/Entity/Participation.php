<?php

namespace Mon\QcmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table("participations")
 * @ORM\Entity(repositoryClass="Mon\QcmBundle\Entity\Repository\ParticipationRepository")
 */
class Participation
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
     * @ORM\Column(name="participation_key", type="string", length=255, unique=true)
     */
    private $participationKey;

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
     * @var \DateTime
     *
     * @ORM\Column(name="participation_started_at", type="datetime", nullable=true)
     */
    private $participationStartedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="participation_ended_at", type="datetime", nullable=true)
     */
    private $participationEndedAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="participations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $user;

    /**
     * @var Qcm
     *
     * @ORM\ManyToOne(targetEntity="Qcm", inversedBy="participations")
     * @ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $qcm;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="ParticipationAnswer", mappedBy="participation")
     */
    private $answers;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Participation
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
     * @return Participation
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
     * Set participationStartedAt
     *
     * @param \DateTime $participationStartedAt
     * @return Participation
     */
    public function setParticipationStartedAt($participationStartedAt)
    {
        $this->participationStartedAt = $participationStartedAt;

        return $this;
    }

    /**
     * Get participationStartedAt
     *
     * @return \DateTime 
     */
    public function getParticipationStartedAt()
    {
        return $this->participationStartedAt;
    }

    /**
     * Set participationEndedAt
     *
     * @param \DateTime $participationEndedAt
     * @return Participation
     */
    public function setParticipationEndedAt($participationEndedAt)
    {
        $this->participationEndedAt = $participationEndedAt;

        return $this;
    }

    /**
     * Get participationEndedAt
     *
     * @return \DateTime 
     */
    public function getParticipationEndedAt()
    {
        return $this->participationEndedAt;
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getParticipationKey()
    {
        return $this->participationKey;
    }

    /**
     * @param string $participationKey
     *
     * @return $this
     */
    public function setParticipationKey($participationKey)
    {
        $this->participationKey = $participationKey;
        return $this;
    }

    /**
     * @param ParticipationAnswer $participationAnswer
     * @return $this
     */
    public function addAnswer(ParticipationAnswer $participationAnswer)
    {
        $this->answers->add($participationAnswer);
        $participationAnswer->setParticipation($this);

        return $this;
    }

    /**
     * @param ParticipationAnswer $participationAnswer
     * @return $this
     */
    public function removeAnswer(ParticipationAnswer $participationAnswer)
    {
        $this->answers->removeElement($participationAnswer);

        return $this;
    }

    // endregion

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
        $this->answers = new ArrayCollection();
    }
}
