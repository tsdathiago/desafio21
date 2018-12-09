<?php
namespace Application\Service;

use Application\Entity\Registry;
use Doctrine\ORM\EntityManager;
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
     * Cria um novo registro de cartório, ou atualiza um
     * registro existente caso o documento já esteja na base de dados
     *
     * @param $data
     * @return Registry
     */
    public function createRegistry($data)
    {

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
}