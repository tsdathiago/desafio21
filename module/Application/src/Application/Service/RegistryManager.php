<?php
namespace Application\Service;

use Application\Entity\Registry;
use Doctrine\ORM\EntityManager;
use Zend\Config\Reader\Xml;

/**
 * Classe responsável pela manutenção de cartórios
 * @package Application\Service
 */
class RegistryManager
{
    /**
     * Inicializa o objeto, sendo necessário passar como argumento
     * o administrador de entidades do Doctrine ORM
     *
     * @param $entityManager EntityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Cria um novo registro de cartório
     *
     * @param $data
     * @return Registry
     */
    public function createRegistry($data)
    {
        $registryOffice = new Registry();
        $registryOffice->setName($data['name']);
        $registryOffice->setRightName($data['right']);
        $registryOffice->setDocument($data['document']);
        $registryOffice->setDocumentType($data['document-type']);
        $registryOffice->setZipcode($data['zipcode']);
        $registryOffice->setAddress($data['address']);
        $registryOffice->setDistrict($data['district']);
        $registryOffice->setCity($data['city']);
        $registryOffice->setState($data['state']);
        $registryOffice->setPhone($data['phone']);
        $registryOffice->setMail($data['mail']);
        $registryOffice->setNotary($data['notary']);
        $registryOffice->setActive($data['active']);

        $this->entityManager->persist($registryOffice);

        try{
            $this->entityManager->flush();
        }
        catch(\Exception $exception){
            return null;
        }

        return $registryOffice;
    }

    /**
     * Salva um registro existente.
     *
     * @param $data
     * @return Registry
     */
    public function saveRegistry($data)
    {

    }

    /**
     * Importa o XML especificado.
     *
     * @param $xml Xml
     */
    public function importRegistryOfficesFromXml($xml){
        $registryOffices = $xml['cartorio'];
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
            return false;
        }
        return true;
    }
}