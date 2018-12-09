<?php

namespace Application\Controller;

use Application\Form\EmailForm;
use Application\Form\ImportXmlForm;
use Application\Form\RegistryForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * @package Application\Controller
 */
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel([
            "form" => new ImportXmlForm(),
            "registryForm" => new RegistryForm(),
            "emailForm" => new EmailForm()
        ]);
    }
}
