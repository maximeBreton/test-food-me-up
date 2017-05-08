<?php

namespace FoodMeUp\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @author breton
 */
class FoodRepository extends EntityRepository
{
    public function getAllFoodId()
    {
        $qb = $this->createQueryBuilder('f')
        ->select('f.origfdcd')
        ->getQuery()
        ->getResult(Query::HYDRATE_ARRAY);

        return array_map('current', $qb);
    }
}
