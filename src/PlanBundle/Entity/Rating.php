<?php

namespace PlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ratingplan
 *
 * @ORM\Table(name="ratingplan")
 * @ORM\Entity(repositoryClass="PlanBundle\Repository\RatingRepository")
 */
class Ratingplan
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
     * @ORM\Column(name="ratingplan", type="integer")
     */
    private $ratingplan;

    /**
     * @var int
     *
     * @ORM\Column(name="plan", type="integer")
     */
    private $plan;






    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ratingplan
     *
     * @param integer $ratingplan
     *
     * @return Ratingplan
     */
    public function setRatingplan($ratingplan)
    {
        $this->ratingplan = $ratingplan;

        return $this;
    }

    /**
     * Get ratingplan
     *
     * @return integer
     */
    public function getRatingplan()
    {
        return $this->ratingplan;
    }

    /**
     * Set plan
     *
     * @param integer $plan
     *
     * @return Ratingplan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return integer
     */
    public function getPlan()
    {
        return $this->plan;
    }
}
