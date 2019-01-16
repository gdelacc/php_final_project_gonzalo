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

use App\Entity\Client;
use Symfony\Component\Form\FormInterface;

interface IClientCrudService {
    /**
     * @return Client[]
     */
    public function getAllClients(); // TO READ: iterator
    /**
     * @param $clientId integer
     * @return Client
     */
    public function getClientById($clientId);
    /**
     * @param $oneClient Client
     */
    public function saveClient($oneClient);
    /**
     * @param $clientId integer
     */
    public function deleteClient($clientId);
}