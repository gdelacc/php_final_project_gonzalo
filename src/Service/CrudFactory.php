<?php
namespace App\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CrudFactory
{
    /** @var EntityManager  */
    private $em;
    /** @var  FormFactory */
    private $formFactory;
    /** @var  Request */
    private $request;
    /**
     * CrudFactory constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $requestStack RequestStack
     */
    public function __construct($em, $form, $requestStack)
    {
        $this->em=$em;
        $this->formFactory=$form;
        $this->request=$requestStack->getCurrentRequest();
        // Request::createFromGlobals()
    }
    /**
     * @return ICarCrudService
     */
    public function getCarService(){
        return new CarCrudService($this->em, $this->formFactory, $this->request);
    }
    /**
     * @return IBrandCrudService
     */
    public function getBrandService(){
        return new BrandCrudService($this->em, $this->formFactory, $this->request);
    }
    /**
     * @return IClientCrudService
     */
    public function getClientService(){
        return new ClientCrudService($this->em, $this->formFactory, $this->request);
    }
    /**
     * @return IRentalCrudService
     */
    public function getRentalService(){
        return new RentalCrudService($this->em, $this->formFactory, $this->request);
    }
}