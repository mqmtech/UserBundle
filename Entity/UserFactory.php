<?php

namespace MQM\UserBundle\Entity;

use MQM\UserBundle\Model\UserFactoryInterface;
use MQM\UserBundle\Entity\User;

class UserFactory implements UserFactoryInterface
{
    private $userClass;
    
    public function __construct($userClass){
        $this->userClass = $userClass;                
    }
    
    /**
     * {@inheritDoc}
     */
    public function createUser(){
        return new $this->userClass();
    }

    /**
     * {@inheritDoc}
     */
    public function getUserClass() {
        return $this->userClass;
    }
}