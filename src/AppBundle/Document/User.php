<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @MongoDB\Document
 */
class User implements UserInterface, EquatableInterface
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $email;

    /**
     * @MongoDB\String
     */
    protected $password;

    /**
     * @MongoDB\Float
     */
    protected $mobile;

    /**
     * @MongoDB\String
     */
    protected $name;

    protected $confirmPassword;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email            
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password            
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set mobile
     *
     * @param float $mobile            
     * @return self
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Get mobile
     *
     * @return float $mobile
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set name
     *
     * @param float $name            
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return float $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Confirm Password
     *
     * @param float $confirmPassword            
     * @return self
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }

    /**
     * Get Confirm Password
     *
     * @return float $confirmPassword
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    public function isConfirmPasswordMatched()
    {
        return ($this->getConfirmPassword() === $this->getPassword());
    }

    public function getRoles()
    {
        return array();
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {}

    public function isEqualTo(UserInterface $user)
    {
        if (! $user instanceof WebserviceUser) {
            return false;
        }
        
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        
        if ($this->salt !== $user->getSalt()) {
            return false;
        }
        
        if ($this->username !== $user->getUsername()) {
            return false;
        }
        
        return true;
    }
}
