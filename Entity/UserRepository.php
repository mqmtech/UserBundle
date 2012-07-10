<?php

namespace MQM\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    const RECENT_MAX_RESULTS = 10;
    const RECENT_ORDER_BY = 'DESC';
    const USER_PERMISSION_TYPE = 'ROLE_USER';    
    
    public function findRecentUsers($max = self::RECENT_MAX_RESULTS)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT user FROM MQMUserBundle:User user WHERE user.permissionType = '". self::USER_PERMISSION_TYPE ."' ORDER BY user.createdAt ".self::RECENT_ORDER_BY;
        $q = $em->createQuery($sql);
        $q->setMaxResults($max);
        $users = $q->getResult();

        return $users;
    }
    
    public function findStaffUsers($max = self::RECENT_MAX_RESULTS)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT user FROM MQMUserBundle:User user WHERE user.permissionType <> '". self::USER_PERMISSION_TYPE ."' ORDER BY user.createdAt ".self::RECENT_ORDER_BY;
        $q = $em->createQuery($sql);
        $users = $q->getResult();

        return $users;
    }

    public function loadUserByUsername($username)
    {
        if($username == null)
            return null;

        $em = $this->getEntityManager();
        $sql = "SELECT user FROM MQMUserBundle:User user WHERE user.isEnabled = :isEnabled AND (user.username = :username OR user.email = :username)";
        $q = $em->createQuery($sql)->setParameters(array(
            'username' => $username,
            'isEnabled' => true
        ));

        return $q->getOneOrNullResult();
    }

    public function refreshUser(UserInterface $user)
    {
        $username = $user->getUsername() ? $user->getUsername() : $user->getEmail();

        return $this->loadUserByUsername($username);
    }

    public function supportsClass($class)
    {
        return $class == 'MQM\UserBundle\Model\UserInterface';
    }
}


