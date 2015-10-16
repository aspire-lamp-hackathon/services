<?php
/**
 * UserProxy
 *
 * Provides (emulated) user level security for APIs
 *
 * @copyright:  Aria Systems, Inc.
 * @author:     David Morfin
 * @version:    $Rev: 11316 $
 */

namespace Aria\CoreBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Aria\DataBundle\Model\WebCore\DashboardUser;
use Aria\DataBundle\Model\WebCore\DashboardUserLevel;
use Aria\DataBundle\Model\WebCore\DashboardUserSectionQuery;
use Aria\DataBundle\Model\WebCore\AdmintoolsSectionQuery;

class DashboardUserProxy implements UserInterface
{
    protected $dashboard_user;
    protected $dashboard_user_level;
    protected $logout;

    public function __construct( DashboardUser $dashboard_user )
    {
        die(print_r($dashboard_user, true));
        $this->dashboard_user = $dashboard_user;
    }

    public function getRoles( )
    {
        return AdmintoolsSectionQuery::create( )
            ->join( 'DashboardUserSection' )
            ->where( 'DashboardUserSection.UserId = ?', $this->getUsername( ) )
            ->find( )
            ->toKeyValue( 'SectionId', 'SectionName' );
    }

    public function getPassword( )
    {
        return false;
    }

    public function getSalt( )
    {
        return false;
    }

    public function eraseCredentials( )
    {
    }

    public function equals( UserInterface $user )
    {
        return $this->getUser( )->equals( $user );
    }

    public function getUser( )
    {
        return $this->dashboard_user;
    }

    public function getUsername( )
    {
        return $this->dashboard_user->getUserId( );
    }

    public function getLevel( )
    {
        if ( empty( $this->dashboard_user ) )
        {
            return -1;
        }
        if ( empty( $this->dashboard_user_level ) )
        {
            $this->dashboard_user_level = $this->dashboard_user->getDashboardUserLevel( );
        }
        if ( empty( $this->dashboard_user_level ) )
        {
            return -1;
        }
        return $this->dashboard_user_level->getLevelNo( );
    }

    // Adding caching here so that switchClient can't make us lose access
    // to date/time functions.  Instead we use old client for duration of 
    // the request.
    protected $cachedClient;
    public function getClient( )
    {
        if ( ! $this->cachedClient )
        {
            if ( ! $this->getDashboardClient( ) )
            {
                throw new \Exception( "No Dashboard Client in scope" );
            }
            $this->cachedClient = $this->getDashboardClient( )->getClient( );
        }
        return $this->cachedClient;
    }

    public function getClientNo( )
    {
        return $this->dashboard_user->getClientNo( );
    }
    
    public function getLogoutUrl( )
    {
        return $this->logoutUrl;
    }
    public function setLogoutUrl( $logoutURL )
    {
        $this->logoutUrl = $logoutURL;
    }

    public function __call( $name, $arguments )
    {
        return call_user_func_array(array($this->dashboard_user,$name), $arguments);
    }
}
