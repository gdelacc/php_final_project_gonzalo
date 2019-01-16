<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Car
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="cars")
 * @ORM\HasLifecycleCallbacks
 */
class Car
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $car_id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $car_inserted;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $car_modified;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $car_visible;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $car_model;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=10, nullable=true)
     */
    private $car_price;

    /**
     * @var Brand
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="brand_cars")
     * @ORM\JoinColumn(name="car_brand", referencedColumnName="brand_id")
     */
    private $car_brand;

    // EXTRA METHODS ...

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(){
        // date("Y-m-d H:i:s")
        $this->car_modified = new \DateTime();
        if ($this->car_inserted==null){
            $this->car_inserted=new \DateTime();
        }
    }

    public function __toString()
    {
        $brandName = $this->car_brand==null ? "X" :
                                $this->car_brand->getBrandName();
        return "{$brandName} {$this->car_model}";
    }

    // AUTO GENERATED
    // REMOVE SETTER FOR ID

    /**
     * @return int
     */
    public function getCarId(): int
    {
        return $this->car_id;
    }

    /**
     * @return \DateTime
     */
    public function getCarInserted(): \DateTime
    {
        return $this->car_inserted;
    }

    /**
     * @param \DateTime $car_inserted
     */
    public function setCarInserted(\DateTime $car_inserted): void
    {
        $this->car_inserted = $car_inserted;
    }

    /**
     * @return \DateTime
     */
    public function getCarModified(): \DateTime
    {
        return $this->car_modified;
    }

    /**
     * @param \DateTime $car_modified
     */
    public function setCarModified(\DateTime $car_modified): void
    {
        $this->car_modified = $car_modified;
    }

    /**
     * @return bool
     */
    public function isCarVisible(): bool
    {
        return $this->car_visible;
    }

    /**
     * @param bool $car_visible
     */
    public function setCarVisible(bool $car_visible): void
    {
        $this->car_visible = $car_visible;
    }

    /**
     * @return string
     */
    public function getCarModel(): string
    {
        return $this->car_model;
    }

    /**
     * @param string $car_model
     */
    public function setCarModel(string $car_model): void
    {
        $this->car_model = $car_model;
    }

    /**
     * @return float
     */
    public function getCarPrice(): float
    {
        return $this->car_price;
    }

    /**
     * @param float $car_price
     */
    public function setCarPrice(float $car_price): void
    {
        $this->car_price = $car_price;
    }

    /**
     * @return Brand
     */
    public function getCarBrand(): Brand
    {
        return $this->car_brand;
    }

    /**
     * @param Brand $car_brand
     */
    public function setCarBrand(Brand $car_brand): void
    {
        $this->car_brand = $car_brand;
    }




}
