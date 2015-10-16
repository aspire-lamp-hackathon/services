<?php
namespace AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class AuthUser implements UserInterface, EquatableInterface
{

    private $container;

    private $username;

    private $password;

    private $salt;

    private $roles;

    public function __construct($container)
    {
        $this->container = $container;        
    }
    
    public function loadUserByUsername($token)
    {
        $userRepository = $this->container->get('doctrine_mongodb')->getManager()
            ->getRepository('AppBundle\Document\User');
        
        $userData = $userRepository->findOneById($token);
        
        return $userData;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
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