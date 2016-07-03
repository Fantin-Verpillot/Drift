<?php

namespace BottleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bottle
 *
 * @ORM\Table(name="bottle")
 * @ORM\Entity(repositoryClass="BottleBundle\Repository\BottleRepository")
 */
class Bottle
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
     * @ORM\JoinColumn(name="fk_receiver", referencedColumnName="id", nullable=true)
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
     * @var int
     *
     * @ORM\Column(name="mark", type="integer", nullable=true)
     */
    private $mark;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="BottleBundle\Entity\Emoji")
     * @ORM\JoinColumn(name="fk_emoji", referencedColumnName="id", nullable=true)
     */
    private $fkEmoji;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=4096)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;


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
     * @return Bottle
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
     * @return Bottle
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
     * @return Bottle
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
     * Set mark
     *
     * @param integer $mark
     * @return Bottle
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return integer 
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set fkEmoji
     *
     * @param integer $fkEmoji
     * @return Bottle
     */
    public function setFkEmoji($fkEmoji)
    {
        $this->fkEmoji = $fkEmoji;

        return $this;
    }

    /**
     * Get fkEmoji
     *
     * @return integer 
     */
    public function getFkEmoji()
    {
        return $this->fkEmoji;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Bottle
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Bottle
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Bottle
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
     * Set image
     *
     * @param string $image
     * @return Bottle
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
}
