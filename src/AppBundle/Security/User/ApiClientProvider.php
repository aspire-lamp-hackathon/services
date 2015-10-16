<?php
/**
 * UserProvider
 *
 * Provides (emulated) user level security for APIs
 *
 * @copyright:  Aria Systems, Inc.
 * @author:     David Morfin
 * @version:    $Rev: 7463 $
 */

namespace Aria\CoreBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiClientProvider extends UserProviderInterface
{
/*    public function __construct( )
    {
        parent::__construct(
            'Aria\DataBundle\Model\WebApi\ApiClient', 
            'Aria\CoreBundle\Security\User\ApiClientUserProxy', 
            'clientNo'
        );
    }*/

    public function loadUserByUsername($username) 
    {
        die($username);
    }
}

