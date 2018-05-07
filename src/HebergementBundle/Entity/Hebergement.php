<?php

namespace HebergementBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hebergement
 *
 * @ORM\Table(name="hebergement")
 * @ORM\Entity
 */
class Hebergement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */


    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=false)
     */
    private $lieu;
    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean", nullable=false)
     */
    private $enable;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="\PiBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id", nullable=true)
     */

    private $idUser;


    /**
     * @var string
     * @Assert\Image()
     * @Assert\NotBlank(message="Ajouter une image")
     * @ORM\Column(name="photo", type="string", nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=10000, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer", nullable=false)
     */
    private $tel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime", nullable=false)
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="site_web", type="string", length=255, nullable=false)
     */
    private $siteWeb;

    /**
     * @var float
     *
     * @ORM\Column(name="x", type="float", nullable=true)
     */
    private $x;

    /**
     * @var float
     *
     * @ORM\Column(name="y", type="float", nullable=true)
     */
    private $y;




    /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string", length=255, nullable=true)
     */
    private $depart;

    /**
     * @var string
     *
     * @ORM\Column(name="depart_id", type="string", length=255, nullable=true)
     */
    private $departId;

    /**
     * @var float
     *
     * @ORM\Column(name="depart_lat", type="float", nullable=true)
     */
    private $departLat;

    /**
     * @var float
     *
     * @ORM\Column(name="depart_lng", type="float", nullable=true)
     */
    private $departLng;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255, nullable=true)
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_id", type="string", length=255, nullable=true)
     */
    private $destinationId;

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
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param string $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param int $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * @param string $siteWeb
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * @param \DateTime $datecreation
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;
    }

    /**
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param float $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param float $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
    }




    /**
     * Get enable
     *
     * @return boolean
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set depart
     *
     * @param string $depart
     *
     * @return Hebergement
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;

        return $this;
    }

    /**
     * Get depart
     *
     * @return string
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * Set departId
     *
     * @param string $departId
     *
     * @return Hebergement
     */
    public function setDepartId($departId)
    {
        $this->departId = $departId;

        return $this;
    }

    /**
     * Get departId
     *
     * @return string
     */
    public function getDepartId()
    {
        return $this->departId;
    }

    /**
     * Set departLat
     *
     * @param float $departLat
     *
     * @return Hebergement
     */
    public function setDepartLat($departLat)
    {
        $this->departLat = $departLat;

        return $this;
    }

    /**
     * Get departLat
     *
     * @return float
     */
    public function getDepartLat()
    {
        return $this->departLat;
    }

    /**
     * Set departLng
     *
     * @param float $departLng
     *
     * @return Hebergement
     */
    public function setDepartLng($departLng)
    {
        $this->departLng = $departLng;

        return $this;
    }

    /**
     * Get departLng
     *
     * @return float
     */
    public function getDepartLng()
    {
        return $this->departLng;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Hebergement
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set destinationId
     *
     * @param string $destinationId
     *
     * @return Hebergement
     */
    public function setDestinationId($destinationId)
    {
        $this->destinationId = $destinationId;

        return $this;
    }

    /**
     * Get destinationId
     *
     * @return string
     */
    public function getDestinationId()
    {
        return $this->destinationId;
    }
}
