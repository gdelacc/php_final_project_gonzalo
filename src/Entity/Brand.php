<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Brand
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="brands")
 */
class Brand
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $brand_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $brand_name;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Car", mappedBy="car_brand")
     */
    private $brand_cars;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brand_description;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $brand_year;


    public function __construct()
    {
        $this->brand_cars=new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getBrandDescription(): string
    {
        return $this->brand_description;
    }

    /**
     * @param string $brand_description
     */
    public function setBrandDescription(string $brand_description): void
    {
        $this->brand_description = $brand_description;
    }

    /**
     * @return int
     */
    public function getBrandYear(): int
    {
        return $this->brand_year;
    }

    /**
     * @param int $brand_year
     */
    public function setBrandYear(int $brand_year): void
    {
        $this->brand_year = $brand_year;
    }

    public function __toString()
    {
        return $this->brand_name;
    }

    // CODE FIRST APPROACH
    // XAMPP control panel, start apache+mysql
    // AUTO GENERATED, BUT REMOVE SETTER FOR ID
    // MANUALLY add addBrandCar / delBrandCar ...
    //
    // \xampp\php\php bin/console doctrine:database:create
    // doctrine:database:create
    // doctrine:schema:drop --force --full-database
    // doctrine:schema:update --force

    /**
     * @return int
     */
    public function getBrandId(): int
    {
        return $this->brand_id;
    }

    /**
     * @return string
     */
    public function getBrandName(): string
    {
        return $this->brand_name;
    }

    /**
     * @param string $brand_name
     */
    public function setBrandName(string $brand_name): void
    {
        $this->brand_name = $brand_name;
    }

    /**
     * @return Collection
     */
    public function getBrandCars(): Collection
    {
        return $this->brand_cars;
    }

    /**
     * @param Collection $brand_cars
     */
    public function setBrandCars(Collection $brand_cars): void
    {
        $this->brand_cars = $brand_cars;
    }



}
