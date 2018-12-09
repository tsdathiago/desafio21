<?php
namespace Application\Service;

use Application\Entity\Registry;
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
        $registryOffices = $data['cartorio'];
        $repository = $this->entityManager->getRepository(Registry::class);

        foreach($registryOffices as $registry){
            // Obtém todos os dados
            $name = $registry['nome'];
            $right = $registry['razao'];
            $documentType = $registry['tipo_documento'] == Registry::DOCUMENT_TYPE_CPF ?
                Registry::DOCUMENT_TYPE_CPF : Registry::DOCUMENT_TYPE_CNPJ;
            $document = $registry['documento'];
            $zipcode = $registry['cep'];
            $address = $registry['endereco'];
            $district = $registry['bairro'];
            $city = $registry['cidade'];
            $state = $registry['uf'];
            $active = $registry['ativo'] == "1" ? "1" : "0";
            $notary = $registry['tabeliao'];
            $phone = isset($registry['telefone']) ? $registry['telefone'] : "";
            $mail = isset($registry['email']) ? $registry['email'] : "";

            // Tenta encontrar uma entidade existente, olhando o documento
            $entity = $repository->findOneBy(array('document' => $document));
            $foundEntity = true;
            if($entity == null){
                $entity = new Registry();
                $foundEntity = false;
            }

            // Atualiza os dados da entidade
            $entity->setName($name);
            $entity->setRightName($right);
            $entity->setDocument($document);
            $entity->setDocumentType($documentType);
            $entity->setZipcode($zipcode);
            $entity->setAddress($address);
            $entity->setCity($city);
            $entity->setDistrict($district);
            $entity->setState($state);
            $entity->setNotary($notary);
            $entity->setActive($active);
            $entity->setPhone($phone);
            $entity->setMail($mail);

            if($foundEntity == false) $this->entityManager->persist($entity);
        }
        try{
            $this->entityManager->flush();
        }
        catch(\Exception $exception){
            echo $exception;
            exit;
        }

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