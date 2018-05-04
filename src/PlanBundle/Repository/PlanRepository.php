<?php

namespace PlanBundle\Repository;


use PlanBundle\Entity\Plan;

class PlanRepository extends \Doctrine\ORM\EntityRepository
{

    function WSChercherDQL ($ville){

        $query = $this->getEntityManager()->createQuery("select v from PlanBundle:Plan v WHERE v.ville=:n1 ")
            ->setParameter('n1',  $ville )  ;
        $query->getResult();
        return $query->getResult();


    }

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


    public function StatGlobaleArrayAction()
    {

        $query = $this->getEntityManager()
            ->createQuery("SELECT  IDENTITY(p.idSc),COUNT(p.idP) as nbrplan,sc.libelle as libsrc
 FROM  PlanBundle:Plan  p  join  PlanBundle:SousCategorie sc WITH p.idSc=sc.idSc  
   GROUP BY p.idSc") ;

        return $query->getResult();
        //  return  $query->getArrayResult();
    }




    public function StatArrayAction($user)
    {

             $query = $this->getEntityManager()
                 ->createQuery("SELECT  IDENTITY(p.idSc),COUNT(p.idP) as nbrplan,sc.libelle as libsrc
 FROM  PlanBundle:Plan  p  join  PlanBundle:SousCategorie sc WITH p.idSc=sc.idSc and   p.user=:n1
   GROUP BY p.idSc")->setParameter('n1',  $user ) ;

       return $query->getResult();
        //  return  $query->getArrayResult();
    }
    public function NotifAction($user)
    {

        $query = $this->getEntityManager()
            ->createQuery("SELECT  p
 FROM  PlanBundle:Plan  p  where  p.etat='1' and p.etatnotif='0' and   p.user=:n1  GROUP BY p.idP")
            ->setParameter('n1',  $user ) ;

        return $query->getResult();
        //  return  $query->getArrayResult();
    }
    public function BienEAction()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM PlanBundle:Plan p
                              JOIN  PlanBundle:SousCategorie s
                              WITH p.idSc=s.idSc JOIN  PlanBundle:Categorie a WITH s.idC = a.idC 
                              WHERE a.libelle='Bienetre' AND p.etat='1'  ");

        return $query->getResult();


    }
    public function FilterAction($typesc )
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


    public function FindplanAction($nom)
    {
        $query = $this->getEntityManager()->createQuery("SELECT p FROM PlanBundle:Plan p
                              JOIN  PlanBundle:SousCategorie s
                              WITH p.idSc=s.idSc JOIN  PlanBundle:Categorie a WITH s.idC = a.idC 
                              WHERE p.etat=1 and   p.libelle like '%$nom%' 
                              or   p.ville like '%$nom%' 
                              order by p.idP ASC");

       return $query->getResult();


    }
}