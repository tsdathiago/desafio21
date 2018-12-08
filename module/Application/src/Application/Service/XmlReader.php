<?php
namespace Application\Service;

use Doctrine\ORM\EntityManager;
use DOMDocument;
use Zend\Config\Reader\Xml;

/**
 * Classe responsável por ler o XML com os dados dos cartórios
 * @package Application\Service
 */
class XmlReader
{
    /**
     * @var EntityManager EntityManager
     */
    private $entityManager;

    /**
     * Inicializa o leitor, sendo necessário passar como argumento
     * o administrador de entidades do Doctrine ORM
     * @param $entityManager EntityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Lê o Xml e retorna true caso tenha dado certo
     * @return bool
     */
    public function readXml($path){
        // Se não for possível ler o arquivo, o processo falhou
        if(!is_readable($path)) return false;

        // Obtém o conteúdo do arquivo e depois o deleta
        $contents = file_get_contents($path);
        unlink($path);

        // Se o conteúdo for inválido, o processo falhou
        if(!$this->isXMLContentValid($contents)) return false;

        // Lê os dados do Xml
        $reader = new Xml();
        $data = $reader->fromString($contents);

        return true;
    }

    /**
     * Função retirada  do stack overflow, faz a validação do XML
     *
     * @param string $xmlContent A well-formed XML string
     * @param string $version 1.0
     * @param string $encoding utf-8
     * @return bool
     */
    public function isXMLContentValid($xmlContent, $version = '1.0', $encoding = 'utf-8')
    {
        if (trim($xmlContent) == '') {return false;}
        libxml_use_internal_errors(true);
        $doc = new DOMDocument($version, $encoding);
        $doc->loadXML($xmlContent);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        return empty($errors);
    }
}