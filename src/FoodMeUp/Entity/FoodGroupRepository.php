<?php

namespace FoodMeUp\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @author breton
 */
class FoodGroupRepository extends EntityRepository
{
    public function getAllFoodGroupId()
    {
        $qb = $this->createQueryBuilder('fg')
            ->select('fg.origgpcd')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        return array_map('current', $qb);
    }
}
