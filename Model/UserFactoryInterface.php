<?php

namespace MQM\UserBundle\Model;

use MQM\UserBundle\Model\UserInterface;

interface UserFactoryInterface
{
    /**
     * @return UserInterface 
     */
    public function createUser();

    /**
     * @return string 
     */
    public function getUserClass();
}