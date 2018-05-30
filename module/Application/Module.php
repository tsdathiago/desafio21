<?php

namespace Application;

use Zend\Mvc\MvcEvent;

/**
 * Class Module
 *
 * @package Application
 */
class Module
{
    /**
     * On bootstrap
     *
     * @param MvcEvent $e
     * @return void
     */
    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();

        /** @var \Doctrine\DBAL\Connection $conn */
        $conn = $serviceManager->get('EntityManager')->getConnection();
        $conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        \Zend\Validator\AbstractValidator::setDefaultTranslator($serviceManager->get('translator'));

        /** @var \Zend\I18n\View\Helper\CurrencyFormat $currencyFormat */
        $currencyFormat = $serviceManager->get('ViewHelperManager')->get('currencyFormat');
        $currencyFormat->setLocale('pt_BR');
        $currencyFormat->setShouldShowDecimals(true);
        $currencyFormat->setCurrencyCode('BRL');
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Get autoloader config
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\ModuleManager\Feature\ServiceProviderInterface::getServiceConfig()
     */
    public function getServiceConfig()
    {
        return [
            'aliases'   => [
                'EntityManager' => \Doctrine\ORM\EntityManager::class,
            ],
            'factories' => [

            ],
        ];
    }
}