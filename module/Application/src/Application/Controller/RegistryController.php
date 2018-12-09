<?php
namespace Application\Controller;

use Application\Entity\Registry;
use Application\Form\EmailForm;
use Application\Form\ImportXmlForm;
use Application\Form\RegistryForm;
use Application\Service\MailSender;
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
            $data = $request->getFiles()->toArray();
            $form->setData($data);

            // Valida o form
            if($form->isValid()){
                $data = $form->getData();

                /** @var $excelReader XmlReader */
                $xmlReader = $this->getServiceLocator()->get(XmlReader::class);
                /** @var $registryManager  RegistryManager */
                $registryManager = $this->getServiceLocator()->get(RegistryManager::class);

                // Lê o XML
                $result = $xmlReader->readXml($data['file']['tmp_name']);

                // Se a leitura foi feita com sucesso, cria todos os cartórios que estão no XML
                if($result != null){
                    $result = $registryManager->importRegistryOfficesFromXml($result);
                }
                else{ // Se a leitura falhou, envia um Json indicando a falha
                    return new JsonModel([
                        "result" => "failure"
                    ]);
                }

                // Verifica se todos os registro foram criados com sucesso
                if($result === true){
                    return new JsonModel([
                        "result" => "success"
                    ]);
                }
                else{ // Se a criação de algum registro falhou, envia um Json indicando a falha
                    return new JsonModel([
                        "result" => "failure"
                    ]);
                }
            }
            else{ // Se o form é inválido, envia código HTTP 404
                $this->getResponse()->setStatusCode(404);
            }
        }
        else{ // Caso a requisição seja GET, envia o código HTTP 404
            $this->getResponse()->setStatusCode(404);
        }
    }

    /**
     * Envia o e-mail especificado pelo usuário para todos os associados ativos
     *
     * @return JsonModel
     */
    public function sendMailAction(){
        $form = new EmailForm();
        $request = $this->getRequest();

        if($request->isPost()){ // Verifica que o método é POST antes de executar as ações necessárias
            // Obtém os dados do form
            $data = $request->getPost()->toArray();

            $form->setData($data);

            if($form->isValid()) { // Valida o form
                $data = $form->getData();

                /** @var $registryManager MailSender */
                $mailSender = $this->getServiceLocator()->get(MailSender::class);

                $config = $this->getServiceLocator()->get('config');
                $mailSender->sendMail($config["mail_sender"], $data["subject"], $data["mail-body"]);

                return new JsonModel([
                    "result" => "success"
                ]);
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
        $form = new RegistryForm(true);
        $request = $this->getRequest();

        if($request->isPost()){ // Verifica que o método é POST antes de executar as ações necessárias
            // Obtém os dados do form
            $data = $request->getPost()->toArray();

            $form->setData($data);

            if($form->isValid()){ // Valida o form
                $data = $form->getData();

                /** @var $entityManager EntityManager */
                $entityManager = $this->getServiceLocator()->get(EntityManager::class);

                /** @var $registryManager RegistryManager */
                $registryManager = $this->getServiceLocator()->get(RegistryManager::class);
                try{
                    $result = $entityManager->getRepository(Registry::class)->findOneBy(["id" => $data["registry-id"]]);
                }
                catch(\Exception $exception){
                    echo $exception;
                    exit;
                }


                if($result != null){
                    $registryOffice = $registryManager->saveRegistry($data);

                    $json = array(
                        "data" => $registryOffice->asArray()
                    );
                    $json['result'] = "success";

                    // Retorna o Json para o cliente
                    return new JsonModel($json);
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

                /** @var $entityManager EntityManager */
                $entityManager = $this->getServiceLocator()->get(EntityManager::class);

                // Verifica se já existe um cartório com o mesmo documento
                $document = $data['document'];
                $registryOffice = $entityManager->getRepository(Registry::class)->findOneBy(array('document' => $document));

                if($registryOffice != null){
                    $this->getResponse()->setStatusCode(404);
                    return new JsonModel([
                        "result" => "failure"
                    ]);
                }

                /** @var $registryManager RegistryManager */
                $registryManager = $this->getServiceLocator()->get(RegistryManager::class);

                $registryOffice = $registryManager->createRegistry($data);

                $json = array(
                    "data" => $registryOffice->asArray()
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
                $json['data'][] = $registryOffice->asArray();
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