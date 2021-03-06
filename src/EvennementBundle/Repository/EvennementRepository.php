<?php

namespace EvennementBundle\Repository;
use Doctrine\ORM\QueryBuilder;
/**
 * EvennementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvennementRepository extends \Doctrine\ORM\EntityRepository
{
    public function MyFindAll($data) {
        $currentdate = new \DateTime('now');
        $queryBuilder = $this->createQueryBuilder('a')->where('a.date_event >= :date')
            ->orderBy('a.date_event','DESC')
            ->setParameter('date', $currentdate->format('Y-m-d'));

        $this->searchEvent($queryBuilder,$data);
        $result = $queryBuilder->getQuery()->execute();
        return $result;

    }
    private function searchEvent(QueryBuilder $qb, $data)
    {
        if(isset($data['CatEvent']) && !empty($data['CatEvent'])){
            $qb->andWhere('a.CatEvent  = :categ')
                ->setParameter('categ', $data['CatEvent']);
        }
        if(isset($data['prix']) && !empty($data['prix'])){
            $qb->andWhere('a.prix  = :prix')
                ->setParameter('prix', $data['prix']);
        }
        if(isset($data['ville']) && !empty($data['ville'])){
            $qb->andWhere('a.ville  like :ville')
                ->setParameter('ville', '%'.$data['ville'].'%');
        }
    }
    private function ordreEvent(QueryBuilder $qb, $data)
    {
        if(isset($data['ordre']) && !empty($data['ordre'])){
            $qb->orderBy('a.'.$data['critere'],$data['ordre']);
        }else{
            $qb->orderBy('a.prix','asc');
        }
    }
}
