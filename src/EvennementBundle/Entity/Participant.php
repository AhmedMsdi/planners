<?php
/**
 * Created by PhpStorm.
 * User: Linab
 * Date: 09/04/2018
 * Time: 16:43
 */

namespace EvennementBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ParticipantE
 *
 * @ORM\Table(name="Participant")
 * @ORM\Entity(repositoryClass="EvennementBundle\Repository\ParticipantRepository")
 */
class Participant
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
     * @ORM\JoinColumn(name="User",referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="EvennementBundle\Entity\Evennement")
     * @ORM\JoinColumn(name="event",referencedColumnName="id")
     */
    private $event;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



}