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

use App\Entity\Rental;
use Symfony\Component\Form\FormInterface;

interface IRentalCrudService {
    /**
     * @return Rental[]
     */
    public function getAllRentals(); // TO READ: iterator
    /**
     * @param $rentalId integer
     * @return Rental
     */
    public function getRentalById($rentalId);
    /**
     * @param $oneRental Rental
     */
    public function saveRental($oneRental);
    /**
     * @param $rentalId integer
     */
    public function deleteRental($rentalId);
}