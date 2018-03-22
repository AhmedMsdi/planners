<?php
/**
 * Created by PhpStorm.
 * User: Linab
 * Date: 20/03/2018
 * Time: 20:27
 */

namespace EventBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\FOSUserBundle;
use PiBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="evennement")
 */
class Evennement
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id_event;

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
     * @ORM\Column(type="date",name="$time_event")
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
     * @ORM\JoinColumn(name="CatEvent",referencedColumnName="id_cat_event",nullable=false)
     */
    private $CatEvent;

    /**
     * @ORM\ManyToOne(targetEntity="PiBundle\Entity\User")
     * @ORM\JoinColumn(name="User",referencedColumnName="id",nullable=false)
     */
    private $User;

    /**
     * Evennement constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdEvent()
    {
        return $this->id_event;
    }

    /**
     * @param mixed $id_event
     */
    public function setIdEvent($id_event)
    {
        $this->id_event = $id_event;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getDateEvent()
    {
        return $this->date_event;
    }

    /**
     * @param mixed $date_event
     */
    public function setDateEvent($date_event)
    {
        $this->date_event = $date_event;
    }

    /**
     * @return mixed
     */
    public function getTimeEvent()
    {
        return $this->time_event;
    }

    /**
     * @param mixed $time_event
     */
    public function setTimeEvent($time_event)
    {
        $this->time_event = $time_event;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getCatEvent()
    {
        return $this->CatEvent;
    }

    /**
     * @param mixed $CatEvent
     */
    public function setCatEvent($CatEvent)
    {
        $this->CatEvent = $CatEvent;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

    /**
     * @return mixed
     */

}