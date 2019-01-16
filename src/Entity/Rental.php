<?php
/**
 * Created by PhpStorm.
 * User: gonzalo
 * Date: 14/01/2019
 * Time: 13:57
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Rental
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="rentals")
 * @ORM\HasLifecycleCallbacks
 */
class Rental
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $rental_id;

    /**
     * @var Client
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client", referencedColumnName="client_id")
     */
    private $client;

    /**
     * @var Car
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumn(name="car", referencedColumnName="car_id")
     */
    private $car;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $start_date;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $end_date;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=10, nullable=true)
     */
    private $rental_price;







    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
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

    /**
     * @return int
     */
    public function getRentalId(): int
    {
        return $this->rental_id;
    }


    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->start_date;
    }

    /**
     * @param \DateTime $start_date
     */
    public function setStartDate(\DateTime $start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->end_date;
    }

    /**
     * @param \DateTime $end_date
     */
    public function setEndDate(\DateTime $end_date): void
    {
        $this->end_date = $end_date;
    }

    /**
     * @return float
     */
    public function getRentalPrice(): float
    {
        return $this->rental_price;
    }

    /**
     * @param float $rental_price
     */
    public function setRentalPrice(float $rental_price): void
    {
        $this->rental_price = $rental_price;
    }


}