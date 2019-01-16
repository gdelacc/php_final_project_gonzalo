<?php

namespace App\DTO;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class TextDTO extends  DTOBase
{
    /**
     * @inheritDoc
     */
    public function __construct(Request $request, FormFactory $formFactory)
    {
        parent::__construct($request, $formFactory);
    }

    /**
     * @var string
     */
    private $textContent = "";

    /**
     * @return string
     */
    public function getTextContent(): string
    {
        return $this->textContent;
    }

    /**
     * @param string $textContent
     */
    public function setTextContent(string $textContent): void
    {
        $this->textContent = $textContent;
    }


    /**
     * @inheritDoc
     */
    public function getForm()
    {
        $builder = $this->formFactory->
                        createBuilder(FormType::class, $this);
        $builder->add("textContent", TextareaType::class);
        //$builder->add("saveToSession", SubmitType::class);
        //$builder->add("saveToFile", SubmitType::class);
        $builder->add("Save Text", SubmitType::class);
        return $builder->getForm();
    }
}