<?php

namespace MQM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

use MQM\UserBundle\Model\UserInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartInterface;
use MQM\PricingBundle\Entity\DiscountRule\DiscountByUserRule;

/**
 *
 * @ORM\Table(name="shop_user")
 * @ORM\Entity(repositoryClass="MQM\UserBundle\Entity\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true, nullable=true)
     */
    private $username;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string $permissionType
     *
     * @ORM\Column(name="permissionType", type="string", length=255, nullable=true)
     */
    private $permissionType;

    /**
     * @var boolean $isEnabled
     *
     * @ORM\Column(name="isEnabled", type="boolean", nullable=true)
     */
    private $isEnabled;

    /**
     * @var string $firstName
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=true)
     */
    private $email;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string $firmName // razon social in spanish
     *
     * @ORM\Column(name="firmName", type="string", length=255, nullable=true)
     */
    private $firmName;

    /**
     * @var string $vatin // value added tax identification number, CIF/NIF in spanish
     *
     * @ORM\Column(name="vatin", type="string", length=255, nullable=true)
     */
    private $vatin;

    /**
     * @var string $zipCode // Codigo Postal in spanish
     *
     * @ORM\Column(name="zipCode", type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @var string $city
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string $province
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    private $province;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string $fax
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     *
     * @var array $orders
     *
     * @ORM\OneToMany(targetEntity="MQM\OrderBundle\Entity\Order",  mappedBy="user", cascade={"persist", "remove"})
     */
    private $orders;
    
    /**
     * @var ShoppingCartInterface $shoppingCart;
     *
     * @ORM\OneToOne(targetEntity="MQM\ShoppingCartBundle\Entity\ShoppingCart", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="shoppingCartId", referencedColumnName="id", nullable=true)
     */
    private $shoppingCart;
    
    /**
     * @var DiscountByUserRule 
     */
    private $discountRule;

    /**
     *
     * @param string $username
     * @param string $password
     * @param string $permissionType
     *
     * WARNING: password must be already encoded by a higher layer (tipically UserManager)
     */
    public function __construct($username = null, $password = null, $permissionType = self::ROLE_USER, $isEnabled = self::DEFAULT_IS_ENABLED)
    {
        if ($username) {
            $this->setUsername($username);
        }
        if ($password) {
            $this->setPassword($password);
        }
        if ($permissionType) {
            $this->setPermissionType($permissionType);
        }

        $this->setIsEnabled($isEnabled);
        $this->setCreatedAt(new \DateTime('now'));
    }

    public function __toString()
    {
        return $this->firstName ? $this->firstName : $this->username ? $this->username : $this->email;
    }

    public function getOffer()
    {
        return $this->offer;
    }

    public function setOffer($offer)
    {
        $this->offer = $offer;
    }


    public function getFirmName()
    {
        return $this->firmName;
    }

    public function setFirmName($firmName)
    {
        $this->firmName = $firmName;
    }

    public function getVatin()
    {
        return $this->vatin;
    }

    public function setVatin($vatin)
    {
        $this->vatin = $vatin;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getProvince()
    {
        return $this->province;
    }

    public function setProvince($province)
    {
        $this->province = $province;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getFax()
    {
        return $this->fax;
    }

    public function setFax($fax)
    {
        $this->fax = $fax;
    }


    public function getOrders()
    {
        return $this->orders;
    }

    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     *
     * @param Order $order
     */
    public function addOrder($order)
    {
        if ($this->getOrders() == null) {
            $this->orders = array();
        }
        $this->orders[] = $order;
        $order->setUser($this); //IMPORTANT to set use to the order as it's the order the owner who saves the user in database
    }

    public function getShoppingCart()
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart($shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * Get isEnabled
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set permissionType
     *
     * @param string $permissionType
     */
    public function setPermissionType($permissionType)
    {
        $this->permissionType = $permissionType;
    }

    /**
     * Get permissionType
     *
     * @return string
     */
    public function getPermissionType()
    {
        return $this->permissionType;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param datetime $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * Get modifiedAt
     *
     * @return datetime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }
    
    public function getDiscountRule()
    {
        return $this->discountRule;
    }

    public function setDiscountRule($discountRule)
    {
        $this->discountRule = $discountRule;
    }
        
    /**
     * @return boolean
     */
    public function isLoggedIn()
    {        
        return self::ROLE_ANON != $this->getPermissionType() && $this->getPermissionType() != null;
    }

    public function isUser(UserInterface $user = null)
    {
        return null !== $user && $this->getId() === $user->getId();
    }

    public function equals(SecurityUserInterface $user)
    {
        return true;
    }

    public function eraseCredentials()
    {
    }

    public function getRoles()
    {
        $rol = $this->getPermissionType();

        $roles = array(
            'ROLE_USER' => self::ROLE_USER,
            'ROLE_BASIC_STAFF' => self::ROLE_BASIC_STAFF,
            'ROLE_STAFF' => self::ROLE_STAFF,
            'ROLE_ADMIN' => self::ROLE_ADMIN,
            'ROLE_SUPER_ADMIN' => self::ROLE_SUPER_ADMIN,
        );

        if (!array_key_exists($rol, $roles)) {
            $rol = self::ROLE_USER;
        }
        
        return array($rol);        
    }

    public function getSalt()
    {
        return null;
    }

    public function serialize()
    {
        return implode(',', array(
            'id' => $this->getId(),
            'username' => $this->getUsername(),
        ));
    }

    public function unserialize($serialized)
    {
        $serialized = explode(',', $serialized);
        $this->setId($serialized[0]);
        $this->setUsername($serialized[1]);
    }
}