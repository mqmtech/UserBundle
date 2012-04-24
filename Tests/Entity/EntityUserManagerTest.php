<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MQM\UserBundle\Test\Entity;


use MQM\UserBundle\Entity\User;
use MQM\UserBundle\Entity\UserManager;
use MQM\UserBundle\Entity\UserFactory;

class EntityUserManagerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{   
    protected $_container;

    public function __construct()
    {
        parent::__construct();
        
        $client = static::createClient();
        $container = $client->getContainer();
        $this->_container = $container;  
    }

    protected function get($service)
    {
        return $this->_container->get($service);
    }
    
    public function testMockSecurityInterface()
    {
        $mock = $this->mockSecurityContext();
        $this->assertTrue($mock instanceof \Symfony\Component\Security\Core\SecurityContextInterface);
    }
    
    public function testMockDoctrineEntityManager()
    {
        $mock = $this->mockDoctrineEntityManager();
        $this->assertTrue($mock instanceof \Doctrine\ORM\EntityManager);        
    }
    
    public function testUserManager(){
        $securityContext = $this->mockSecurityContext();
        $entityManager = $this->mockDoctrineEntityManager();
        $userFactory = new UserFactory('MQM\UserBundle\Entity\User');
        $cartManager = $this->get('mqm_cart.cart_manager');
        
        $userManager = new UserManager($entityManager, $securityContext, $userFactory, $cartManager);
        $this->assertNotNull($userManager);
        
        $user = $userManager->createUser();
        $this->assertNotNull($user);
    }
    
    public function testUserManagerByContainer(){
        $userManager = $securityContext = $this->get('mqm_user.user_manager');
        
        $this->assertNotNull($userManager);
        
        $user = $userManager->createUser();
        $this->assertNotNull($user);
    }
    
    public function mockSecurityContext(){
        $spec = $this->getMockBuilder('\Symfony\Component\Security\Core\SecurityContextInterface')->disableOriginalConstructor();
        $mock = $spec->getMock();
        
        return $mock;
    }
    
    public function mockDoctrineEntityManager(){
        $spec = $this->getMockBuilder('\Doctrine\ORM\EntityManager')->disableOriginalConstructor();
        $mock = $spec->getMock();
        
        return $mock;
    }
    
}
