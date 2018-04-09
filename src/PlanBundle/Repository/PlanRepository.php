<?php

namespace PlanBundle\Repository;


class PlanRepository extends \Doctrine\ORM\EntityRepository
{
    public function DivertisementsAction()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM PlanBundle:Plan p
                              JOIN  PlanBundle:SousCategorie s
                              WITH p.idSc=s.idSc JOIN  PlanBundle:Categorie a WITH s.idC = a.idC 
                              WHERE a.libelle='Divertissement' AND p.etat='1' ");

        return $query->getResult();


    }
    public function GastronomieAction()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM PlanBundle:Plan p
                              JOIN  PlanBundle:SousCategorie s
                              WITH p.idSc=s.idSc JOIN  PlanBundle:Categorie a WITH s.idC = a.idC 
                              WHERE a.libelle='Gastronomie' AND p.etat='1'");

        return $query->getResult();


    }
    public function BienEAction()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM PlanBundle:Plan p
                              JOIN  PlanBundle:SousCategorie s
                              WITH p.idSc=s.idSc JOIN  PlanBundle:Categorie a WITH s.idC = a.idC 
                              WHERE a.libelle='Bienetre' AND p.etat='1'");

        return $query->getResult();


    }
    public function FilterAction($typesc  )
    {
            $query = $this->getEntityManager()->createQuery("SELECT p FROM PlanBundle:Plan p
                              JOIN  PlanBundle:SousCategorie s
                              WITH p.idSc=s.idSc JOIN  PlanBundle:Categorie a WITH s.idC = a.idC 
                              WHERE p.etat=1 and p.idSc=:n1    
                              order by p.idP ASC")
                ->setParameter('n1',  $typesc ) ;

            return $query->getResult();


    }
    public function FindAction($recher,$Reg)
    {
        $query = $this->getEntityManager()->createQuery("SELECT p FROM PlanBundle:Plan p
                              JOIN  PlanBundle:SousCategorie s
                              WITH p.idSc=s.idSc JOIN  PlanBundle:Categorie a WITH s.idC = a.idC 
                              WHERE p.etat=1 and   p.libelle like '%$recher%' 
                              and   p.ville like '%$Reg%' 
                              order by p.idP ASC");
      //  ->setParameter('n2', '%'.$recher.'%');

        return $query->getResult();


    }
}