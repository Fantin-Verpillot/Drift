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
     * @ORM\Column(name="lessage", type="string", length=4096)
     */
    private $lessage;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * Set lessage
     *
     * @param string $lessage
     * @return BottleAdmin
     */
    public function setLessage($lessage)
    {
        $this->lessage = $lessage;

        return $this;
    }

    /**
     * Get lessage
     *
     * @return string 
     */
    public function getLessage()
    {
        return $this->lessage;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return BottleAdmin
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
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
}
