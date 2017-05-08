<?php

namespace FoodMeUp\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @author breton
 */
class ComponentRepository extends EntityRepository
{
    public function getAllComponentCOrigcpnmabr()
    {
        $qb = $this->createQueryBuilder('c')
        ->select('c.cOrigcpnmabr')
        ->getQuery()
        ->getResult(Query::HYDRATE_ARRAY);

        return array_map('current', $qb);
    }
}