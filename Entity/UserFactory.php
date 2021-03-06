<?php

namespace MQM\UserBundle\Entity;

use MQM\UserBundle\Model\UserFactoryInterface;
use MQM\UserBundle\Model\UserInterface;

class UserFactory implements UserFactoryInterface
{
    private $userClass;
    
    public function __construct($userClass){
        $this->userClass = $userClass;                
    }

    /**
     * {@inheritDoc}
     */
    public function createUser($enabled = false, $role = UserInterface::ROLE_USER)
    {
        $user = new $this->userClass();
        $user->setPermissionType($role);
        $user->setIsEnabled($enabled);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserClass() {
        return $this->userClass;
    }
}