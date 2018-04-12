<?php
/**
 * Created by PhpStorm.
 * User: Linab
 * Date: 10/04/2018
 * Time: 13:14
 */

namespace EvennementBundle\Repository;


class ParticipantRepository extends \Doctrine\ORM\EntityRepository
{
    public function countVisitedEvent($eventid){

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT count(f)
        FROM EvennementBundle:Participant f
        WHERE f.event = :id'
        )
            ->setParameter('id',$eventid);

        return $query->getSingleScalarResult();
    }
}