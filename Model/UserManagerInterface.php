<?php

namespace MQM\UserBundle\Model;

use MQM\UserBundle\Model\UserInterface;

interface UserManagerInterface 
{    
    const RECENT_MAX_RESULTS = 10;
    
    /**
     * @return UserInterface
     */
    public function createUser();
    
    /**
     *
     * @param UserInterface $user
     * @param boolean $andFlush 
     */
    public function saveUser(UserInterface $user, $andFlush = true);
    
    /**
     *
     * @param UserInterface $user
     * @param boolean $andFlush 
     */
    public function deleteUser(UserInterface $user, $andFlush = true);
    
    /**
     *
     * @return UserInterface
     */
    public function getCurrentUser();
    
    /**
     * @return boolean 
     */
    public function isDBUser($user);       
    
    /**
     * @return UserInterface
     */
    public function findUserBy(array $criteria);
    
    /**
     * @return array  
     */
    public function findUsers();
    
    /**
     * @return array 
     */
    public function findRecentUsers($max = self::RECENT_MAX_RESULTS);
}