<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Essa classe representa um cartório, e contém todos os dados que anteriormente eram guardados na planilha.
 *
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="registry")
 */
class Registry{
    /**
     * Contante que representa que o tipo do documento é CPF.
     */
    const DOCUMENT_TYPE_CPF = 1;
    /**
     * Contante que representa que o tipo do documento é CNPJ.
     */
    const DOCUMENT_TYPE_CNPJ = 2;

    /**
     * @var $id string
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @var $name string
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @var $rightName string
     * @ORM\Column(name="right_name")
     */
    protected $rightName;

    /**
     * @var $document string
     * @ORM\Column(name="document")
     */
    protected $document;

    /**
     * @var $documentType string
     * @ORM\Column(name="document_type")
     */
    protected $documentType;

    /**
     * @var $zipcode string
     * @ORM\Column(name="zipcode")
     */
    protected $zipcode;

    /**
     * @var $address string
     * @ORM\Column(name="address")
     */
    protected $address;

    /**
     * @var $district string
     * @ORM\Column(name="district")
     */
    protected $district;

    /**
     * @var $city string
     * @ORM\Column(name="city")
     */
    protected $city;

    /**
     * @var $state string
     * @ORM\Column(name="state")
     */
    protected $state;

    /**
     * @var $phone string
     * @ORM\Column(name="phone")
     */
    protected $phone;

    /**
     * @var $mail string
     * @ORM\Column(name="mail")
     */
    protected $mail;

    /**
     * @var $notary string
     * @ORM\Column(name="notary")
     */
    protected $notary;

    /**
     * @var $active string
     * @ORM\Column(name="active")
     */
    protected $active;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRightName()
    {
        return $this->rightName;
    }

    /**
     * @param string $rightName
     */
    public function setRightName($rightName)
    {
        $this->rightName = $rightName;
    }

    /**
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * Obtém o tipo de documento do cartório. Pode assumir os seguintes valores:
     *
     * 1 - CPF
     * 2 - CNPJ
     *
     * @return int
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Altera o tipo de documento do cartório. Pode assumir os seguintes valores:
     *
     * 1 - CPF
     * 2 - CNPJ
     *
     * @param int $documentType
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param string $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getNotary()
    {
        return $this->notary;
    }

    /**
     * @param string $notary
     */
    public function setNotary($notary)
    {
        $this->notary = $notary;
    }

    /**
     * @see Registry::$active
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param string $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}