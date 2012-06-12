<?php

namespace MQM\UserBundle\Entity;

use MQM\UserBundle\Model\UserManagerInterface;
use MQM\UserBundle\Model\UserFactoryInterface;
use MQM\UserBundle\Model\UserInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class UserManager implements UserManagerInterface
{
    private $entityManager;    
    private $repository;    
    private $userFactory;
    private $shoppingCartManager;
    
    public function __construct(EntityManager $entityManager, UserFactoryInterface $userFactory, ShoppingCartManagerInterface $shoppingCartManager) 
    {
        $this->entityManager = $entityManager;
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
    public function refreshUser(UserInterface $user)
    {
        return $this->getRepository()->refreshUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function findUserByEmail($email)
    {
        return $this->findUserBy(array('email' => $email));
    }

    /**
     * {@inheritDoc}
     */
    public function findUserByUsername($username)
    {
        return $this->findUserBy(array('username' =>$username));
    }

    /**
     * {@inheritDoc}
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * {@inheritDoc}
     */
    public function validateUnique(UserInterface $user, $property)
    {
       $fields = array_map('trim', explode(',', $property));
       $criteria = $this->getCriteria($user, $fields);
       $users = $this->getRepository()->findBy($criteria);
       if ($users == null || empty($user)) {
           return true;
       }
       if ($this->anyIsUser($user, $users)) {
           return true;
       }

       return false;
    }

    /**
     * Indicates whether the given user and all compared objects correspond to the same record.
     *
     * @param UserInterface $user
     * @param array         $comparisons
     * @return Boolean
     */
    protected function anyIsUser($user, array $comparisons)
    {
        foreach ($comparisons as $comparison) {
            if (!$user->isUser($comparison)) {
                return false;
            }
        }

        return true;
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
    public function findUsersBy(array $criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    /**
     * {@inheritDoc} 
     */
    public function findUsers()
    {
        return $this->getRepository()->findAll();
    }
    
    public function findStaffUsers()
    {
        return $this->getRepository()->findStaffUsers();
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

    /**
     * Gets the criteria used to find conflictual entities.
     *
     * @param UserInterface $user
     * @param array         $fields
     * @return array
     */
    protected function getCriteria($user, array $fields)
    {
        $class = $this->getUserFactory()->getUserClass();
        $classMetadata = $this->entityManager->getClassMetadata($class);
        $criteria = array();
        foreach ($fields as $field) {
            if (!$classMetadata->hasField($field)) {
                throw new \InvalidArgumentException(sprintf('The "%s" class metadata does not have any "%s" field or association mapping.', $class, $field));
            }

            $criteria[$field] = $classMetadata->getFieldValue($user, $field);
        }

        return $criteria;
    }
}
