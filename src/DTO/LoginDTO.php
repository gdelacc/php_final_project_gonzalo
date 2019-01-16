<?php

namespace App\DTO;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class LoginDTO extends DTOBase
{
    // ALT + INSERT
    // Override => constructor
    // ADD fields
    // Getters and setters
    // Implement => getForm

    public function __construct(Request $request, FormFactory $formFactory)
    {
        parent::__construct($request, $formFactory);
    }

    /**
     * @inheritDoc
     */
    public function getForm()
    {
        $builder = $this->formFactory->
            createBuilder(FormType::class, $this);
        $builder->add("userName", TextType::class);
        $builder->add("userPass", PasswordType::class);
        $builder->add("SEND", SubmitType::class);
        return $builder->getForm();
    }

    /**
     * @var string
     */
    protected $userName = "";
    /**
     * @var string
     */
    protected $userPass = "";

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserPass(): string
    {
        return $this->userPass;
    }

    /**
     * @param string $userPass
     */
    public function setUserPass(string $userPass): void
    {
        $this->userPass = $userPass;
    }


}