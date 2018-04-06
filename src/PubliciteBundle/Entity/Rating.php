<?php

namespace PubliciteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="PubliciteBundle\Repository\RatingRepository")
 */
class Rating
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
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @var int
     *
     * @ORM\Column(name="evenement", type="integer")
     */
    private $publicite;


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
     * Set rating
     *
     * @param integer $rating
     *
     * @return rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set publicite
     *
     * @param integer $publicite
     *
     * @return rating
     */
    public function setPublicite($publicite)
    {
        $this->publicite = $publicite;

        return $this;
    }

    /**
     * Get publicite
     *
     * @return int
     */
    public function getPublicite()
    {
        return $this->publicite;
    }
}