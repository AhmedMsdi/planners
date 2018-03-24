<?php

namespace EvennementBundle\Entity;

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
     */
    private $titre;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="date",name="date_event")
     */
    private $date_event;

    /**
     * @ORM\Column(type="date",name="time_event")
     */
    private $time_event;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $image;


    /**
     * @ORM\Column(type="float")
     */
    private  $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="CategorieEvent")
     * @ORM\JoinColumn(name="CatEvent",referencedColumnName="id",nullable=false)
     */
    private $CatEvent;

    /**
     * @ORM\ManyToOne(targetEntity="PiBundle\Entity\User")
     * @ORM\JoinColumn(name="User",referencedColumnName="id",nullable=false)
     */
    private $User;

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
}
