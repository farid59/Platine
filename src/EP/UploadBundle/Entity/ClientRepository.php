<?php

namespace EP\UploadBundle\Entity;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByField($field, $value, $user)
    {
        $qb = $this->createQueryBuilder('c');
        $parameters = array();

        $qb->andwhere("c.owner = :owner");
        $parameters["owner"] = $user;

        if (null !== $field && null !== $value) {
            $qb->andwhere("c.".$field." LIKE :value");
            $parameters["value"] = "%".$value."%";
        }

        $qb->setParameters($parameters);

        return $qb->getQuery()->getResult();
    }

    public function findLast($user)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->andwhere("c.owner = :owner")
            ->setParameter("owner",$user)
            ->setMaxResults(5);

        return $queryBuilder->getQuery()->getResult();
    }


    public function count($user){
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('count(c)')
            ->andwhere("c.owner = :owner")
            ->setParameter("owner",$user);
        return $queryBuilder->getQuery()->getSingleScalarResult();   
    }
}
