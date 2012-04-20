<?php

namespace MQM\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    const RECENT_MAX_RESULTS = 10;
    const RECENT_ORDER_BY = 'DESC';
    const USER_PERMISSION_TYPE = 'ROLE_USER';    
    
    public function findRecentUsers($max = self::RECENT_MAX_RESULTS)
    {
        $em = $this->getEntityManager();
        $sql = "select user from MQMUserBundle:User user WHERE user.permissionType = '". self::USER_PERMISSION_TYPE ."' ORDER BY user.createdAt ".self::RECENT_ORDER_BY;
        $q = $em->createQuery($sql);
        $q->setMaxResults($max);
        $users = $q->getResult();

        return $users;
    }
}


