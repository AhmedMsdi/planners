<?php

namespace PubliciteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicite
 *
 * @ORM\Table(name="publicite", indexes={@ORM\Index(name="fk1_pub", columns={"id_u"})})
 * @ORM\Entity
 */
class Publicite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_pub", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPub;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=20, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=20, nullable=false)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="site_web", type="string", length=20, nullable=false)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=20, nullable=false)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="PiBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $idU;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_click", type="integer", nullable=true)
     */
    private $nbClick = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="ETAT", type="integer", nullable=false)
     */
    private $etat = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;





    /**
     * Set image
     *
     * @param string $image
     *
     * @return Publicite
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
     * Set text
     *
     * @param string $text
     *
     * @return Publicite
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     *
     * @return Publicite
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Publicite
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
     * Set idU
     *
     * @param integer $idU
     *
     * @return Publicite
     */
    public function setIdU($idU)
    {
        $this->idU = $idU;

        return $this;
    }

    /**
     * Get idU
     *
     * @return integer
     */
    public function getIdU()
    {
        return $this->idU;
    }

    /**
     * Set nbClick
     *
     * @param integer $nbClick
     *
     * @return Publicite
     */
    public function setNbClick($nbClick)
    {
        $this->nbClick = $nbClick;

        return $this;
    }

    /**
     * Get nbClick
     *
     * @return integer
     */
    public function getNbClick()
    {
        return $this->nbClick;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Publicite
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Publicite
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
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
}
