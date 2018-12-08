<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;

/**
 * Classe que representa o form de importação de um arquivo Xml
 * @package Application\Form
 */
class ImportXmlForm extends Form{

    /**
     * Inicializa o form
     */
    public function __construct()
    {
        parent::__construct("import-xml-form");

        $this->setAttribute("method", "post");

        $this->createFormElements();
    }

    /**
     * Cria os elementos do form
     */
    private function createFormElements(){
        // Cria o input do arquivo
        $this->add([
            "type" => "file",
            "name" => "file",
            "attributes" => [
                "id" => "file"
            ]
        ]);

        /** @var InputFilter $inputFilter */
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            "type" => FileInput::class,
            "name" => "file",
            "required" => true,
            "validators" => [
                ["name" => "FileUploadFile"],
                [
                    "name" => "FileSize",
                    "options" => [
                        "maxWidth" => 10240, // 10MB
                        "maxHeight" => 10240 // 10MB
                    ]
                ]
            ],
            "filters" => [
                [
                    "name" => "FileRenameUpload",
                    "options" => [
                        "target" => "./xml",
                        'useUploadName' => true,
                        'useUploadExtension' => true,
                        'overwrite' => true,
                        'randomize' => false
                    ]
                ]
            ]
        ]);
    }
}