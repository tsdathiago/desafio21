<?php
namespace Application\Factory;

use Application\Service\XmlReader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;

/**
 * Classe responsável por criar objetos ExcelReader
 * @package Application\Factory
 */
class XmlReaderFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $entityManager EntityManager */
        $entityManager = $serviceLocator->get(EntityManager::class);
        return new XmlReader($entityManager);
    }
}