<?php

namespace App\Service;

/*
\xampp\php\php bin/console doctrine:schema:drop --force --full-database
\xampp\php\php bin/console doctrine:database:create
\xampp\php\php bin/console doctrine:schema:update --force
\xampp\php\php bin/console doctrine:fixtures:load --no-interaction -vvv
*/
// list all methods required for managing cars
// Possibility to split up into multiple interfaces
//      (interface+class hierarchy)
//      READ: REPOSITORY PATTERN
//      NOT TO MIX: DOCTRINE REPOSITORY
//      (when controller -> custom repository... Ours is controller -> service -> default repository )

use App\Entity\Car;
use Symfony\Component\Form\FormInterface;

interface ICarCrudService {
    /**
     * @return Car[]
     */
    public function getAllCars(); // TO READ: iterator
    /**
     * @param $brandId integer
     * @return Car[]
     */
    public function getCarsByBrand($brandId);
    /**
     * @param $isVisible boolean
     * @return Car[]
     */
    public function getCarsByVisibility($isVisible);
    /**
     * @param $carId integer
     * @return Car
     */
    public function getCarById($carId);
    /**
     * @param $oneCar Car
     */
    public function saveCar($oneCar);
    /**
     * @param $carId integer
     */
    public function deleteCar($carId);
    /**
     * @param $oneCar Car
     * @return FormInterface
     */
    public function getCarForm($oneCar);
}