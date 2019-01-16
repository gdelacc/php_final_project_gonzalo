<?php
/**
 * Created by PhpStorm.
 * User: gonzalo
 * Date: 14/01/2019
 * Time: 14:06
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="repairs")
 * @ORM\HasLifecycleCallbacks
 */
class Repair
{

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $reparation_id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $reparation_date;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @var Car
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumn(name="car", referencedColumnName="car_id")
     */
    private $car;

    /**
     * @return int
     */
    public function getReparationId(): int
    {
        return $this->reparation_id;
    }

    /**
     * @return \DateTime
     */
    public function getReparationDate(): \DateTime
    {
        return $this->reparation_date;
    }

    /**
     * @param \DateTime $reparation_date
     */
    public function setReparationDate(\DateTime $reparation_date): void
    {
        $this->reparation_date = $reparation_date;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->car;
    }

    /**
     * @param Car $car
     */
    public function setCar(Car $car): void
    {
        $this->car = $car;
    }


}