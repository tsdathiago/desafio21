<?php

namespace Application\Controller;

use Application\Form\ImportXmlForm;
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
            "form" => new ImportXmlForm()
        ]);
    }
}
