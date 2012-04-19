<?php

namespace MQM\UserBundle\Entity;

use MQM\UserBundle\Model\UserManagerInterface;
use MQM\UserBundle\Model\UserFactoryInterface;
use MQM\UserBundle\Model\UserInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartManagerInterface;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContextInterface;

class UserManager implements UserManagerInterface {
    
    private $securityContext;    
    private $entityManager;    
    private $repository;    
    private $userFactory;
    private $shoppingCartManager;
    
    public function __construct(EntityManager $entityManager, SecurityContextInterface $securityContext, UserFactoryInterface $userFactory, ShoppingCartManagerInterface $shoppingCartManager) 
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->userFactory = $userFactory;        
        $this->shoppingCartManager = $shoppingCartManager;
        $userClass = $userFactory->getUserClass();
        $this->repository = $entityManager->getRepository($userClass);        
    }
    
    /**
     * {@inheritDoc} 
     */
    public function createUser() 
    {
        $user = $this->getUserFactory()->createUser();
        $cart = $this->shoppingCartManager->createCart();
        $user->setShoppingCart($cart);
        
        return $user;
    }    
    
    /**
     * {@inheritDoc} 
     */
    public function saveUser(UserInterface $user, $andFlush = true)
    {
        $this->getEntityManager()->persist($user);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * {@inheritDoc} 
     */
    public function deleteUser(UserInterface $user, $andFlush = true)
    {
        $this->getEntityManager()->remove($user);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * {@inheritDoc} 
     */
    public function getCurrentUser()
    {
        $securityContext = $this->getSecurityContext();
        if ($securityContext != null) {
            $token = $securityContext->getToken();
            if ($token) 
                return $token->getUser(); 
            return 'anon';
        }
        else {
            throw new \Exception("Custom Exception: No SecurityContext has been setted in UserManager");
        }
    }  
    
    /**
     * {@inheritDoc} 
     */
    public function isDBUser($user)
    {
        $isDBUser = false;
        if($user == null || gettype($user) == "string"){
            $isDBUser = false;
        }
        else{
            if(method_exists($user, "isDBUser")){
                $isDBUser = $user->isDBUser();
            }
            else{
                $isDBUser = false;
            }
        }
        
        return $isDBUser;
    }    
    
    /**
     * {@inheritDoc} 
     */
    public function findUserBy(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * {@inheritDoc} 
     */
    public function findUsers()
    {
        return $this->getRepository()->findAll();
    }
    
    /**
     * {@inheritDoc} 
     */
    public function findRecentUsers($max = null)
    {
        $users = $this->getRepository()->findRecentUsers($max);

        return $users;
    }
    /**
     *
     * @return SecurityContextInterface
     */
    protected function getSecurityContext() 
    {
        return $this->securityContext;
    }

    /**
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }
    
    /**
     *
     * @return UserFactoryInterface
     */
    protected function getUserFactory()
    {
        return $this->userFactory;
    }
    
    /**
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->repository;
    }
}
