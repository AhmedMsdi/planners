<?php
/**
 * Created by PhpStorm.
 * User: Linab
 * Date: 21/03/2018
 * Time: 01:15
 */

namespace EventBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categorie_event")
 */
class CategorieEvent
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id_CatEvent;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $libelle;

    /**
     * CategorieEvent constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdCatEvent()
    {
        return $this->id_CatEvent;
    }

    /**
     * @param mixed $id_CatEvent
     */
    public function setIdCatEvent($id_CatEvent)
    {
        $this->id_CatEvent = $id_CatEvent;
    }

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

}