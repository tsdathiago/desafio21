<?php
namespace Application\Controller;

use Application\Entity\Registry;
use Application\Form\ImportXmlForm;
use Application\Form\RegistryForm;
use Application\Service\RegistryManager;
use Application\Service\XmlReader;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

/**
 * Classe que controla as ações relacionadas à leitura/gravação de dados dos cartórios
 * @package Application\Controller
 */
class RegistryController extends AbstractActionController{

    /**
     * Inicializa o banco de dados, convertendo os dados do Xml
     * @return JsonModel
     */
    public function importRegistryOfficesAction(){
        $form = new ImportXmlForm();
        $request = $this->getRequest();

        if($request->isPost()){ // Verifica que o método é POST antes de executar as ações necessárias

            // Obtém os dados do form
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($data);

            if($form->isValid()){ // Valida o form
                $data = $form->getData();

                /** @var $excelReader XmlReader */
                $xmlReader = $this->getServiceLocator()->get(XmlReader::class);

                $result = $xmlReader->readXml($data['file']['tmp_name']);

                if($result === true){
                    return new JsonModel([
                        "result" => "success"
                    ]);
                }
                else{
                    return new JsonModel([
                        "result" => "failure"
                    ]);
                }
            }
            else{
                $this->getResponse()->setStatusCode(404);
            }
        }
        else{ // Caso a requisição seja GET, envia o código HTTP 404
            $this->getResponse()->setStatusCode(404);
        }
    }

    /**
     * Salva o cartório especificado pelo usuário
     * @return JsonModel
     */
    public function saveRegistryAction(){
        $form = new RegistryForm();
        $request = $this->getRequest();

        if($request->isPost()){ // Verifica que o método é POST antes de executar as ações necessárias
            // Obtém os dados do form
            $data = $request->getPost()->toArray();

            $form->setData($data);

            if($form->isValid()){ // Valida o form
                $data = $form->getData();

                /** @var $registryManager RegistryManager */
                $registryManager = $this->getServiceLocator()->get(RegistryManager::class);

                $registryOffice = $registryManager->saveRegistry($data);

                $json = array(
                    "data" => [
                        $registryOffice->getId(),
                        $registryOffice->getName(),
                        $registryOffice->getPhone(),
                        $registryOffice->getMail()
                    ]
                );
                $json['result'] = "success";

                // Retorna o Json para o cliente
                return new JsonModel($json);
            }
            else{
                $this->getResponse()->setStatusCode(404);
            }
        }
        else{ // Caso a requisição seja GET, envia o código HTTP 404
            $this->getResponse()->setStatusCode(404);
        }
    }

    /**
     * Cria o cartório especificado pelo usuário
     * @return JsonModel
     */
    public function createRegistryAction(){
        $form = new RegistryForm();
        $request = $this->getRequest();

        if($request->isPost()){ // Verifica que o método é POST antes de executar as ações necessárias
            // Obtém os dados do form
            $data = $request->getPost()->toArray();

            $form->setData($data);

            if($form->isValid()){ // Valida o form
                $data = $form->getData();

                /** @var $registryManager RegistryManager */
                $registryManager = $this->getServiceLocator()->get(RegistryManager::class);

                $registryOffice = $registryManager->createRegistry($data);

                $json = array(
                    "data" => [
                        $registryOffice->getId(),
                        $registryOffice->getName(),
                        $registryOffice->getPhone(),
                        $registryOffice->getMail()
                    ]
                );
                $json['result'] = "success";

                // Retorna o Json para o cliente
                return new JsonModel($json);
            }
            else{
                $this->getResponse()->setStatusCode(404);
            }
        }
        else{ // Caso a requisição seja GET, envia o código HTTP 404
            $this->getResponse()->setStatusCode(404);
        }
    }

    /**
     * Retorna ao usuário um Json contendo todos os cartórios registrados
     * @return JsonModel
     */
    public function getAllRegistryOfficesAction()
    {
        /** @var $entityManager EntityManager */
        $entityManager = $this->getServiceLocator()->get(EntityManager::class);

        // Garante que é uma requisição POST
        if($this->getRequest()->isPost()){
            /**
             * Obtém a lista de todos os cartórios através do repositório
             * @var $registryOffices Registry[]
             */
            $registryOffices = $entityManager->getRepository(Registry::class)->findAll();

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
            $json['result'] = "success";


            // Retorna o Json para o cliente
            return new JsonModel($json);
        }
        else{ // Caso a requisição seja GET, envia o código HTTP 404
            $this->getResponse()->setStatusCode(404);
        }
    }
}