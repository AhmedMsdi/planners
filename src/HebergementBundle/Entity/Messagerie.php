<?php

namespace HebergementBundle\Entity;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Messagerie
 *
 * @ORM\Table(name="messagerie")
 * @ORM\Entity(repositoryClass="HebergementBundle\Repository\MessagerieRepository")
 */
class Messagerie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="typemessage", type="string", length=255)
     */
    private $typemessage;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="idClient", type="string")
     */
    private $idClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="datetime")
     */
    private $datedebut;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefin", type="datetime")
     */
    private $datefin;
    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @return int
     */
    public function getNbrPerson()
    {
        return $this->nbrPerson;
    }

    /**
     * @param int $nbrPerson
     */
    public function setNbrPerson($nbrPerson)
    {
        $this->nbrPerson = $nbrPerson;
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_person", type="integer")
     */
    private $nbrPerson;
    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="idheb", type="integer")
     */
    private $idheb;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typemessage
     *
     * @param string $typemessage
     *
     * @return Messagerie
     */
    public function setTypemessage($typemessage)
    {
        $this->typemessage = $typemessage;

        return $this;
    }

    /**
     * Get typemessage
     *
     * @return string
     */
    public function getTypemessage()
    {
        return $this->typemessage;
    }

    /**
     * Set idUser
     *
     * @param string $idUser
     *
     * @return Messagerie
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idClient
     *
     * @param string $idClient
     *
     * @return Messagerie
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return string
     */
    public function getIdClient()
    {
        return $this->idClient;
    }
    /**
     * @return int
     */
    public function getIdheb()
    {
        return $this->idheb;
    }

    /**
     * @param int $idheb
     */
    public function setIdheb($idheb)
    {
        $this->idheb = $idheb;
    }

    /**
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param \DateTime $datedebut
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param \DateTime $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    }



}

