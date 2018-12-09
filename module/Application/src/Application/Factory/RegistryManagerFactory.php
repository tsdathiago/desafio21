<?php
namespace Application\Factory;

use Application\Service\RegistryManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;

/**
 * Classe responsável por criar o objetos RegistryManager
 * @package Application\Factory
 */
class RegistryManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $entityManager EntityManager */
        $entityManager = $serviceLocator->get(EntityManager::class);
        return new RegistryManager($entityManager);
    }
}