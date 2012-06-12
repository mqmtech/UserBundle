<?php

namespace MQM\UserBundle\Helper;

use MQM\UserBundle\Model\UserInterface;

interface UserAuthenticatedResolverInterface
{    
    /**
     * @return UserInterface 
     */
    public function getCurrentUser();
    
    /**
     * @return boolean 
     */
    public function isLoggedIn($user);
}