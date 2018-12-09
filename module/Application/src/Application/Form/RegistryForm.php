<?php
namespace Application\Form;

use Application\Entity\Registry;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Classe for formulário de edição dos cartórios
 * @package Application\Form
 */
class RegistryForm extends Form
{
    /**
     * Indica se um form de edição
     * @var bool
     */
    private $editForm = false;

    /**
     * Inicializa o form
     */
    public function __construct($editForm = false)
    {
        parent::__construct("registry-form");

        $this->setAttribute("method", "post");
        $this->createFormElements();
        $this->createFilters();
    }

    /**
     * Cria os elementos do form
     */
    private function createFormElements()
    {
        // Adiciona o campo Nome
        $this->add([
            "type" => "text",
            "name" => "name",
            "attributes" => [
                "id" => "name",
                'required' => true
            ],
            "options" => [
                "label" => "Nome"
            ]
        ]);

        // Adiciona o campo Razão
        $this->add([
            "type" => "text",
            "name" => "right",
            "attributes" => [
                "id" => "right",
                'required' => true
            ],
            "options" => [
                "label" => "Razão Social"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "document",
            "attributes" => [
                "id" => "document",
                'required' => true
            ],
            "options" => [
                "label" => "Documento"
            ]
        ]);

        // Adicionar o campo Tipo de Documento
        $this->add([
            'type'  => 'select',
            'name' => 'document-type',
            'attributes' => [
                'id' => 'document-type'
            ],
            'options' => [
                'label' => 'Tipo de Documento',
                'value_options' => [
                    Registry::DOCUMENT_TYPE_CPF => 'CPF',
                    Registry::DOCUMENT_TYPE_CNPJ => 'CNPJ',
                ]
            ]
        ]);

        // Adiciona o campo CEP
        $this->add([
            "type" => "text",
            "name" => "zipcode",
            "attributes" => [
                "id" => "zipcode",
                'required' => true
            ],
            "options" => [
                "label" => "CEP"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "address",
            "attributes" => [
                "id" => "address",
                'required' => true
            ],
            "options" => [
                "label" => "Endereço"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "district",
            "attributes" => [
                "id" => "district",
                'required' => true
            ],
            "options" => [
                "label" => "Bairro"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "city",
            "attributes" => [
                "id" => "city",
                'required' => true
            ],
            "options" => [
                "label" => "Cidade"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "state",
            "attributes" => [
                "id" => "state",
                'required' => true
            ],
            "options" => [
                "label" => "Estado (UF)"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "phone",
            "attributes" => [
                "id" => "phone"
            ],
            "options" => [
                "label" => "Telefone"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "mail",
            "attributes" => [
                "id" => "mail"
            ],
            "options" => [
                "label" => "E-mail"
            ]
        ]);

        // Adiciona o campo Documento
        $this->add([
            "type" => "text",
            "name" => "notary",
            "attributes" => [
                "id" => "notary",
                'required' => true
            ],
            "options" => [
                "label" => "Nome do Tabelião"
            ]
        ]);

        // Adiciona o campo ativo
        $this->add([
            "type" => "checkbox",
            "name" => "active",
            "attributes" => [
                "id" => "active"
            ],
            "options" => [
                "label" => "Ativo",
                "checked_value" => "1"
            ]
        ]);

        // Adiciona o campo Nome
        $this->add([
            "type" => "text",
            "name" => "registry-id",
            "attributes" => [
                "id" => "registry-id"
            ],
            "options" => [
                "label" => "ID",
            ]
        ]);
    }

    /**
     * Cria os filtros dos campos do form
     */
    private function createFilters(){
        /** @var $inputFilter InputFilter */
        $inputFilter = $this->getInputFilter();

        // Campo nome
        $inputFilter->add([
            "name" => "name",
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
                        'max' => 150
                    ],
                ]
            ]
        ]);

        // Campo razão
        $inputFilter->add([
            "name" => "right",
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
                        'max' => 150
                    ],
                ]
            ]
        ]);

        // Campo documento
        $inputFilter->add([
            "name" => "document",
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
                        'max' => 20
                    ],
                ]
            ]
        ]);

        // Campo tipo de documento
        $inputFilter->add([
            'name' => 'document-type',
            'required' => true,
            'validators' => [
                [
                    'name' => 'InArray',
                    'options'=> [
                        'haystack' => [Registry::DOCUMENT_TYPE_CPF, Registry::DOCUMENT_TYPE_CNPJ],
                    ]
                ],
            ]
        ]);

        // Campo CEP
        $inputFilter->add([
            "name" => "zipcode",
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
                        'max' => 10
                    ],
                ]
            ]
        ]);

        // Campo endereço
        $inputFilter->add([
            "name" => "address",
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
                        'max' => 150
                    ],
                ]
            ]
        ]);

        // Campo bairro
        $inputFilter->add([
            "name" => "district",
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
                        'max' => 20
                    ],
                ]
            ]
        ]);

        // Campo cidade
        $inputFilter->add([
            "name" => "city",
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
                        'max' => 20
                    ],
                ]
            ]
        ]);

        // Campo estado (uf)
        $inputFilter->add([
            "name" => "state",
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
                        'max' => 2
                    ],
                ]
            ]
        ]);

        // Campo e-mail
        $inputFilter->add([
            "name" => "mail",
            "required" => false,
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
                        'max' => 100
                    ],
                ]
            ]
        ]);

        // Campo telefone
        $inputFilter->add([
            "name" => "phone",
            "required" => false,
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
                        'max' => 20
                    ],
                ]
            ]
        ]);

        // Campo nome do tabelião
        $inputFilter->add([
            "name" => "notary",
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
                        'max' => 150
                    ],
                ]
            ]
        ]);

        // Campo nome do tabelião
        $inputFilter->add([
            "name" => "active",
            "required" => true,
            "filters" => [
                [
                    'name' => 'Boolean',
                    "options" => [
                        "type" => "integer"
                    ]
                ],
            ],
            "validators" => [
            ]
        ]);

        $idValidators = $this->editForm ? [
            [
                "name" => "Digits"
            ]
        ] : [];
        // Campo ID
        $inputFilter->add([
            "name" => "registry-id",
            "required" => $this->editForm,
            "filters" => [
                [
                    'name' => 'Int'
                ],
            ],
            "validators" => $idValidators
        ]);
    }
}