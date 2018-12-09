<?php
namespace Application\Service;

use Doctrine\ORM\EntityManager;
use Application\Entity\Registry;
use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

/**
 * Classe responsável por enviar e-mails para os associados
 *
 * @package Application\Service
 */
class MailSender
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
     * Envia o e-mail especificado para todos os associados ativos
     *
     * @param $subject string
     * @param $body string
     */
    public function sendMail($sender, $subject, $body){
        $repository = $this->entityManager->getRepository(Registry::class);

        /** @var $registryOffices Registry[] */
        $registryOffices = $repository->findBy(["active" => "1"]);
        try{
            $mail = new Message();
            $mail->setFrom($sender);
            $mail->setSubject($subject);
            $mail->setBody($body);

            foreach ($registryOffices as $registryOffice){
                if(!empty($registryOffice->getMail())){
                    $mail->addTo($registryOffice->getMail());
                }
            }

            $transport = new Sendmail('-f'.$sender);
            $transport->send($mail);
        }
        catch(\Exception $exception){
        }
    }
}