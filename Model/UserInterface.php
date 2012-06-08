<?php

namespace MQM\UserBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

interface UserInterface extends SecurityUserInterface, \Serializable
{
    const ROLE_ANON =           "ROLE_ANON";
    const ROLE_USER =           "ROLE_USER";
    const ROLE_BASIC_STAFF =    "ROLE_BASIC_STAFF";
    const ROLE_STAFF =          "ROLE_STAFF";
    const ROLE_ADMIN =          "ROLE_ADMIN";
    const ROLE_SUPER_ADMIN =    "ROLE_SUPER_ADMIN";
    const DEFAULT_IS_ENABLED =  false;
    
    public function getOffer();
    
    public function setOffer($offer);
    
    public function getFirmName();
    
    public function setFirmName($firmName);
    
    public function getVatin();
    
    public function setVatin($vatin);
    
    public function getZipCode();
    
    public function setZipCode($zipCode);
    
    public function getCity();
    
    public function setCity($city);
    
    public function getProvince();
    
    public function setProvince($province);
    
    public function getPhone();
    
    public function setPhone($phone);
    
    public function getFax();
    
    public function setFax($fax);
    
    public function getOrders();
    
    public function setOrders($orders);
    
    public function addOrder($order);
    
    public function getShoppingCart();
    
    public function setShoppingCart($shoppingCart);
    
    public function getId();
    
    public function setId($id);
    
    public function setFirstName($firstName);
    
    public function getFirstName();
    
    public function setLastName($lastName);
    
    public function getLastName();
    
    public function setEmail($email);
    
    public function getEmail();
    
    public function setAddress($address);
    
    public function getAddress();
    
    public function setIsEnabled($isEnabled);
    
    public function getIsEnabled();
    
    public function setPermissionType($permissionType);
    
    public function getPermissionType();
    
    public function setCreatedAt($createdAt);
    
    public function getCreatedAt();
    
    public function setModifiedAt($modifiedAt);
    
    public function getModifiedAt();
    
    public function isLoggedIn();

    public function isUser(UserInterface $user = null);
    
    public function setPassword($password);
    
    public function setUsername($username);
    
    /*
    public function getUsername();    
 
    public function getPassword();

    public function equals(SecurityUserInterface $user);

    public function eraseCredentials();

    public function getRoles();

    public function getSalt();

    public function serialize();

    public function unserialize($serialized);
     */
}