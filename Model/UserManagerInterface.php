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
    public function refreshUser(UserInterface $user);

    /**
     *
     * @return UserInterface
     */
    public function findUserByUsernameOrEmail($usernameOrEmail);

    /**
     * @param string $username
     * @return UserInterface
     */
    public function findUserByUsername($username);

    /**
     * @param string $email
     * @return UserInterface
     */
    public function findUserByEmail($email);

    /**
     * @param UserInterface $user
     * @param $string
     * @return boolean
     */
    public function validateUnique(UserInterface $user, $property);
    
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
    public function findStaffUsers();

    /**
     * @return array
     */
    public function findUsersBy(array $criteria);
    
    /**
     * @return array 
     */
    public function findRecentUsers($max = self::RECENT_MAX_RESULTS);
}