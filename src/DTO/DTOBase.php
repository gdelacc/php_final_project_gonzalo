<?php

namespace App\DTO;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class DTOBase
{
    // DI Container
    // IoC Container (Inversion of Control)
    // Service Container
    // Discouraged: Service Locator - hidden dependencies
    /**
     * @var FormFactory
     */
    protected $formFactory;
    /**
     * @var Request
     */
    protected $request;

    /**
     * DTOBase constructor.
     * @param $request Request
     * @param $formFactory FormFactory
     */
    public function __construct($request, $formFactory)
    {
        $this->request = $request;
        $this->formFactory = $formFactory;
    }
    /**
     * @return FormInterface
     */
    public abstract function getForm();
}