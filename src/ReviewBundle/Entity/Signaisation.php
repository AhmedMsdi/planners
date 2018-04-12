<?php

namespace ReviewBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Signaisation
 *
 * @ORM\Table(name="signaisation")
 * @ORM\Entity(repositoryClass="ReviewBundle\Repository\SignaisationRepository")
 */
class Signaisation
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
     * @ORM\ManyToOne(targetEntity="PiBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="PlanBundle\Entity\Plan")
     * @ORM\JoinColumn(name="id_plan",referencedColumnName="id_p")
     */
    private $idPlan;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="raison", type="string", length=255, nullable=true)
     */
    private $raison;


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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Signaisation
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idPlan
     *
     * @param integer $idPlan
     *
     * @return Signaisation
     */
    public function setIdPlan($idPlan)
    {
        $this->idPlan = $idPlan;

        return $this;
    }

    /**
     * Get idPlan
     *
     * @return int
     */
    public function getIdPlan()
    {
        return $this->idPlan;
    }

    /**
     * Set raison
     *
     * @param string $raison
     *
     * @return Signaisation
     */
    public function setRaison($raison)
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * Get raison
     *
     * @return string
     */
    public function getRaison()
    {
        return $this->raison;
    }
}

