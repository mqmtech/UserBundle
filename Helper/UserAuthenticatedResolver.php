<?php

namespace MQM\UserBundle\Helper;

use MQM\UserBundle\Helper\UserAuthenticatedResolverInterface;
use MQM\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use MQM\UserBundle\Model\UserInterface;

class UserAuthenticatedResolver implements UserAuthenticatedResolverInterface
{    
    private $securityContext;
    private $userManager;
    
    public function __construct(SecurityContextInterface $securityContext, UserManagerInterface $userManager)
    {
        $this->securityContext = $securityContext;
        $this->userManager = $userManager;        
    }
    
    /**
     * {@inheritDoc} 
     */
    public function getCurrentUser()
    {
        $token = $this->securityContext->getToken();
        if ($token) {
            $user = $token->getUser();
            if (!is_string($user))
                return $this->userManager->refreshUser($user);

            return $this->createAnonymousUser();
        }
        
        return $this->createAnonymousUser();
    }
    
    private function createAnonymousUser()
    {
        $user = $this->userManager->createUser();
        $user->setPermissionType(UserInterface::ROLE_ANON);
        $user->setUsername('anon.');
        
        return $user;
    }
    
    /**
     * {@inheritDoc} 
     */
    public function isLoggedIn($user)
    {
        $isLoggedIn = false;
        if($user == null || gettype($user) == "string"){
            $isLoggedIn = false;
        }
        else{
            if(method_exists($user, "isLoggedIn")){
                $isLoggedIn = $user->isLoggedIn();
            }
            else{
                $isLoggedIn = false;
            }
        }
        
        return $isLoggedIn;
    }
}