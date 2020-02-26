<?php


namespace jardin\MainBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function rechercherUserParent(){
        $requette = $this->getEntityManager()->createQuery("SELECT tiffany FROM MainBundle:User tiffany
         WHERE  tiffany.roles='a:1:{i:0;s:11:\"ROLE_PARENT\";}'");
        return $requette->getResult();

    }

}