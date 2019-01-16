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

use App\Entity\Brand;
use Symfony\Component\Form\FormInterface;

interface IBrandCrudService {
    /**
     * @return Brand[]
     */
    public function getAllBrands(); // TO READ: iterator
    /**
     * @param $brandId integer
     * @return Brand
     */
    public function getBrandById($brandId);
    /**
     * @param $oneBrand Brand
     */
    public function saveBrand($oneBrand);
    /**
     * @param $brandId integer
     */
    public function deleteBrand($brandId);
}