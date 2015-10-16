<?php
namespace AppBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use AppBundle\Security\Authentication\Token\AuthUserToken;
use Symfony\Component\Security\Core\Util\StringUtils;
use AppBundle\Security\Authentication\Token\AuthToken;

class AuthProvider implements AuthenticationProviderInterface
{

    private $userProvider;

    private $cacheDir;

    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());
        if ($user) {
            $authenticatedToken = new AuthToken($user->getRoles());
            $authenticatedToken->setUser($user);
            
            return $authenticatedToken;
        }
        
        throw new AuthenticationException('The WSSE authentication failed.');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof AuthToken;
    }
}