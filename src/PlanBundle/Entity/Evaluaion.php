<?php

namespace PlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluaion
 *
 * @ORM\Table(name="evaluaion", uniqueConstraints={@ORM\UniqueConstraint(name="ID_USR", columns={"ID_USR", "ID_PUB"})})
 * @ORM\Entity
 */
class Evaluaion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_EV", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEv;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_USR", type="integer", nullable=false)
     */
    private $idUsr;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_PUB", type="integer", nullable=false)
     */
    private $idPub;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;



    /**
     * Get idEv
     *
     * @return integer
     */
    public function getIdEv()
    {
        return $this->idEv;
    }

    /**
     * Set idUsr
     *
     * @param integer $idUsr
     *
     * @return Evaluaion
     */
    public function setIdUsr($idUsr)
    {
        $this->idUsr = $idUsr;

        return $this;
    }

    /**
     * Get idUsr
     *
     * @return integer
     */
    public function getIdUsr()
    {
        return $this->idUsr;
    }

    /**
     * Set idPub
     *
     * @param integer $idPub
     *
     * @return Evaluaion
     */
    public function setIdPub($idPub)
    {
        $this->idPub = $idPub;

        return $this;
    }

    /**
     * Get idPub
     *
     * @return integer
     */
    public function getIdPub()
    {
        return $this->idPub;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Evaluaion
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }
}
