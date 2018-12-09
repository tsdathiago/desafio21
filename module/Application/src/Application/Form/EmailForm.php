<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Classe responsável por enviar e-mails para os cartórios
 * @package Application\Form
 */
class EmailForm extends Form
{
    public function __construct()
    {
        parent::__construct("mail-form");

        $this->setAttribute("method", "post");
        $this->createFormElements();
        $this->createFilters();
    }

    /**
     * Cria os elementos do form
     */
    private function createFormElements()
    {
        // Adiciona o campo Assunto
        $this->add([
            "type" => "text",
            "name" => "subject",
            "attributes" => [
                "id" => "subject",
                'required' => true
            ],
            "options" => [
                "label" => "Assunto"
            ]
        ]);

        // Adiciona o campo Assunto
        $this->add([
            "type" => "textarea",
            "name" => "mail-body",
            "attributes" => [
                "id" => "mail-body",
                'required' => true,
                "rows" => 3
            ],
            "options" => [
                "label" => "Corpo do E-mail"
            ]
        ]);
    }

    /**
     * Cria os filtros dos campos do form
     */
    private function createFilters()
    {
        /** @var $inputFilter InputFilter */
        $inputFilter = $this->getInputFilter();

        // Campo documento
        $inputFilter->add([
            "name" => "subject",
            "required" => true,
            "filters" => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines']
            ],
            "validators" => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 50
                    ],
                ]
            ]
        ]);

        // Campo documento
        $inputFilter->add([
            "name" => "mail-body",
            "required" => true,
            "filters" => [
                ['name' => 'StringTrim']
            ],
            "validators" => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1
                    ]
                ]
            ]
        ]);
    }
}