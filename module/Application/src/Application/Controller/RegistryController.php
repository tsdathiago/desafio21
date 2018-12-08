<?php
namespace Application\Controller;

use Application\Entity\Registry;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

/**
 * Classe que controla as ações relacionadas à leitura/gravação de dados dos cartórios
 * @package Application\Controller
 */
class RegistryController extends AbstractActionController{
    /**
     * @var $entityManager EntityManager
     */
    private $entityManager;

    /**
     * Retorna ao usuário um Json contendo todos os cartórios registrados
     * @return JsonModel
     */
    public function getAllRegistryOfficesAction()
    {
        $this->entityManager = $this->getServiceLocator()->get(EntityManager::class);

        // Garante que é uma requisição POST
        if($this->getRequest()->isPost()){
            /**
             * Obtém a lista de todos os cartórios através do repositório
             * @var $registryOffices Registry[]
             */
            $registryOffices = $this->entityManager->getRepository(Registry::class)->findAll();

            // Itera pela lista de cartórios para criar o Json
            $json = array(
                "data" => []
            );
            foreach($registryOffices as $registryOffice){
                $json['data'][] = [
                    $registryOffice->getId(),
                    $registryOffice->getName(),
                    $registryOffice->getPhone(),
                    $registryOffice->getMail()
                ];
            }

            // Retorna o Json para o cliente
            return new JsonModel($json);
        }
        else{ // Caso a requisição seja GET, envia o código HTTP 404
            $this->getResponse()->setStatusCode(404);
        }
    }
}