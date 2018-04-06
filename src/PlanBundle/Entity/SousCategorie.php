<?php

namespace PlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousCategorie
 *
 * @ORM\Table(name="sous_categorie", indexes={@ORM\Index(name="fk1_sou", columns={"id_c"})})
 * @ORM\Entity
 */
class SousCategorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_sc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSc;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=100, nullable=false)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_c", referencedColumnName="id_c")
     * })
     */
    private $idC;

    /**
     * @return int
     */
    public function getIdSc()
    {
        return $this->idSc;
    }

    /**
     * @param int $idSc
     */
    public function setIdSc($idSc)
    {
        $this->idSc = $idSc;
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
     * @return \Categorie
     */
    public function getIdC()
    {
        return $this->idC;
    }

    /**
     * @param \Categorie $idC
     */
    public function setIdC($idC)
    {
        $this->idC = $idC;
    }


}

