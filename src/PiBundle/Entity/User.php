<?php
/**
 * Created by PhpStorm.
 * User: Marwen
 * Date: 29/10/2017
 * Time: 18:29
 */
namespace PiBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $nom;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $prenom;

    /**
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $point_fidelite = '0';


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set pointFidelite
     *
     * @param integer $pointFidelite
     *
     * @return User
     */
    public function setPointFidelite($pointFidelite)
    {
        $this->point_fidelite = $pointFidelite;

        return $this;
    }

    /**
     * Get pointFidelite
     *
     * @return integer
     */
    public function getPointFidelite()
    {
        return $this->point_fidelite;
    }
}
