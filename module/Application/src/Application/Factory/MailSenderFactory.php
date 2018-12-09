<?php

namespace Application\Factory;

use Application\Service\MailSender;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;

class MailSenderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $entityManager EntityManager */
        $entityManager = $serviceLocator->get(EntityManager::class);
        return new MailSender($entityManager);
    }
}