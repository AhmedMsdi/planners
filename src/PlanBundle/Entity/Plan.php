<?php

namespace PlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plan
 *
 * @ORM\Table(name="plan", indexes={@ORM\Index(name="IDX_DD5A5B7D510DF12F", columns={"id_sc"})})
 * @ORM\Entity (repositoryClass="PlanBundle\Repository\PlanRepository")
 */
class Plan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_p", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idP;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=100, nullable=false)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=100, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=100, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=200, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="avis", type="string", length=20, nullable=true)
     */
    private $avis;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=20, nullable=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=true)
     */
    private $prix;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="ETAT", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="ETATNOTIF", type="integer", nullable=false)
     */
    private $etatnotif;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;



    /**
     * @ORM\ManyToOne(targetEntity="PiBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $user;

    /**
     * @var \SousCategorie
     *
     * @ORM\ManyToOne(targetEntity="SousCategorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sc", referencedColumnName="id_sc")
     * })
     */
    private $idSc;

    /**
     * @return int
     */
    public function getIdP()
    {
        return $this->idP;
    }

    /**
     * @param int $idP
     */
    public function setIdP($idP)
    {
        $this->idP = $idP;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
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
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * @param string $avis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

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
     * @return int
     */
    public function getEtatnotif()
    {
        return $this->etatnotif;
    }

    /**
     * @param int $etatnotif
     */
    public function setEtatnotif($etatnotif)
    {
        $this->etatnotif = $etatnotif;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return \SousCategorie
     */
    public function getIdSc()
    {
        return $this->idSc;
    }

    /**
     * @param \SousCategorie $idSc
     */
    public function setIdSc($idSc)
    {
        $this->idSc = $idSc;
    }


    /**
     * Set user
     *
     * @param \PiBundle\Entity\User $user
     *
     * @return Plan
     */
    public function setUser(\PiBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PiBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

}

