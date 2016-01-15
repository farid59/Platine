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
}
