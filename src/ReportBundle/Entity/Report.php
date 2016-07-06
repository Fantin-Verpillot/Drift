<?php

namespace ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table(name="report")
 * @ORM\Entity(repositoryClass="ReportBundle\Repository\ReportRepository")
 */
class Report
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
     * @ORM\ManyToOne(targetEntity="BottleBundle\Entity\Bottle")
     * @ORM\JoinColumn(name="fk_bottle", referencedColumnName="id", nullable=false)
     */
    private $fkBottle;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    public function constructReport($fkBottle, $state)
    {
        $this->fkBottle = $fkBottle;
        $this->state = $state;
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
     * Set fkBottle
     *
     * @param integer $fkBottle
     * @return Report
     */
    public function setFkBottle($fkBottle)
    {
        $this->fkBottle = $fkBottle;

        return $this;
    }

    /**
     * Get fkBottle
     *
     * @return integer 
     */
    public function getFkBottle()
    {
        return $this->fkBottle;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Report
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
}
