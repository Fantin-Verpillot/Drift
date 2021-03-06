<?php

namespace BottleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BottleAdmin
 *
 * @ORM\Table(name="bottle_admin")
 * @ORM\Entity(repositoryClass="BottleBundle\Repository\BottleAdminRepository")
 */
class BottleAdmin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_receiver", referencedColumnName="id", nullable=false)
     */
    private $fkReceiver;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_transmitter", referencedColumnName="id", nullable=false)
     */
    private $fkTransmitter;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=4096)
     */
    private $message;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="received_date", type="datetime", nullable=true)
     */
    private $receivedDate;


    /**
     * Get receivedDate
     *
     * @return \DateTime
     */
    public function getReceivedDate()
    {
        return $this->receivedDate;
    }


    /**
     * Set receivedDate
     * @param $receivedDate
     * @return $this
     */
    public function setReceivedDate($receivedDate)
    {
        $this->receivedDate = $receivedDate;

        return $this;
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
     * Set fkReceiver
     *
     * @param integer $fkReceiver
     * @return BottleAdmin
     */
    public function setFkReceiver($fkReceiver)
    {
        $this->fkReceiver = $fkReceiver;

        return $this;
    }

    /**
     * Get fkReceiver
     *
     * @return integer 
     */
    public function getFkReceiver()
    {
        return $this->fkReceiver;
    }

    /**
     * Set fkTransmitter
     *
     * @param integer $fkTransmitter
     * @return BottleAdmin
     */
    public function setFkTransmitter($fkTransmitter)
    {
        $this->fkTransmitter = $fkTransmitter;

        return $this;
    }

    /**
     * Get fkTransmitter
     *
     * @return integer 
     */
    public function getFkTransmitter()
    {
        return $this->fkTransmitter;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return BottleAdmin
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return BottleAdmin
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return BottleAdmin
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    public function getSourceRole() {
        return 'ROLE_ADMIN';
    }
}
