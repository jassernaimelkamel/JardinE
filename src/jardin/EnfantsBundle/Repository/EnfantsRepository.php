<?php


namespace jardin\EnfantsBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EnfantsRepository extends  EntityRepository
{
    public function rechercherEnfantsParNom($nom){
        $requette = $this->createQueryBuilder('tiffany');
            $requette->where('tiffany.nom=:nom')->setParameter('nom',$nom);
            return $requette->getQuery()->getResult();

    }

    public function rechercherEnfantsParNom2($argument){
        $requette = $this->getEntityManager()->createQuery("SELECT tiffany FROM EnfantsBundle:Enfants tiffany
         WHERE tiffany.nom='$argument' OR tiffany.prenom='$argument' OR tiffany.sexe='$argument'
         OR tiffany.lieuNaissance ='$argument' OR tiffany.medecin='$argument' OR tiffany.medecinNumero= '$argument'");
        return $requette->getResult();

    }

    public function rechercherEnfantsGirl(){
        $requette = $this->getEntityManager()->createQuery("SELECT tiffany FROM EnfantsBundle:Enfants tiffany
         WHERE  tiffany.sexe='f'");
        return $requette->getResult();

    }

    public function rechercherEnfantsBoy(){
        $requette = $this->getEntityManager()->createQuery("SELECT tiffany FROM EnfantsBundle:Enfants tiffany
         WHERE  tiffany.sexe='m'");
        return $requette->getResult();

    }

    public function rechercherEnfantsParSexe(){
        $requette = $this->getEntityManager()->createQuery("SELECT tiffany.sexe,count(tiffany.sexe) nombre FROM EnfantsBundle:Enfants tiffany
         group by  tiffany.sexe");
        return $requette->getResult();

    }

}