<?php

namespace EvennementBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Evennement
 *
 * @ORM\Table(name="evennement")
 * @ORM\Entity(repositoryClass="EvennementBundle\Repository\EvennementRepository")
 */
class Evennement
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $titre;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $ville;

    /**
     * @ORM\Column(type="date",name="date_event")
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $date_event;

    /**
     * @ORM\Column(type="time",name="time_event")
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $time_event;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $image;


    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private  $prix;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $contact;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etat;

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }


    /**
     * @ORM\ManyToOne(targetEntity="EvennementBundle\Entity\CategorieEvent")
     * @ORM\JoinColumn(name="CatEvent",referencedColumnName="id",nullable=false)
     * @Assert\NotBlank(message="Champs obligatoire")
     */
    private $CatEvent;

    /**
     * @ORM\ManyToOne(targetEntity="PiBundle\Entity\User")
     * @ORM\JoinColumn(name="User",referencedColumnName="id")
     */
    private $User;

    private $editImage;

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Evennement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Evennement
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Evennement
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set dateEvent
     *
     * @param \DateTime $dateEvent
     *
     * @return Evennement
     */
    public function setDateEvent($dateEvent)
    {
        $this->date_event = $dateEvent;

        return $this;
    }

    /**
     * Get dateEvent
     *
     * @return \DateTime
     */
    public function getDateEvent()
    {
        return $this->date_event;
    }

    /**
     * Set timeEvent
     *
     * @param \DateTime $timeEvent
     *
     * @return Evennement
     */
    public function setTimeEvent($timeEvent)
    {
        $this->time_event = $timeEvent;

        return $this;
    }

    /**
     * Get timeEvent
     *
     * @return \DateTime
     */
    public function getTimeEvent()
    {
        return $this->time_event;
    }


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Evennement
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Evennement
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set contact
     *
     * @param integer $contact
     *
     * @return Evennement
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return integer
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set catEvent
     *
     * @param \EvennementBundle\Entity\CategorieEvent $catEvent
     *
     * @return Evennement
     */
    public function setCatEvent(\EvennementBundle\Entity\CategorieEvent $catEvent)
    {
        $this->CatEvent = $catEvent;

        return $this;
    }


    /**
     * Get catEvent
     *
     * @return \EvennementBundle\Entity\CategorieEvent
     */
    public function getCatEvent()
    {
        return $this->CatEvent;

    }

    /**
     * Set user
     *
     * @param \PiBundle\Entity\User $user
     *
     * @return Evennement
     */
    public function setUser(\PiBundle\Entity\User $user)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PiBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evennement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set editImage
     *
     * @param string $editImage
     *
     * @return Evennement
     */
    public function setEditImage($editImage)
    {
        $this->editImage = $editImage;

        return $this;
    }


    /**
     * Get editImage
     *
     * @return string
     */
    public function getEditImage()
    {
        return $this->editImage;
    }

    function __toString()
    {
           return(string) $this->titre;


    }

}
