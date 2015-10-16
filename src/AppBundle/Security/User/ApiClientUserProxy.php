<?php
/**
 * UserProxy
 *
 * Provides (emulated) user level security for APIs
 *
 * @copyright:  Aria Systems, Inc.
 * @author:     David Morfin
 * @version:    $Rev: 10293 $
 */

namespace Aria\CoreBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Aria\DataBundle\Model\WebApi\ApiClient;
use Aria\DataBundle\Model\WebCore\AdmintoolsClientSectionQuery;
use Aria\DataBundle\Model\WebCore\AdmintoolsSectionQuery;
use Aria\DataBundle\Model\WebApi\AllClientValidIpRangesQuery;
use Aria\DataBundle\Model\WebApi\ApiClientValidIpRangesQuery;

class ApiClientUserProxy implements UserInterface
{
    protected $api_client;

    public function __construct( ApiClient $api_client )
    {
        $this->api_client = $api_client;
    }

    public function getRoles( )
    {
        return AdmintoolsSectionQuery::create( )
            ->join( 'AdmintoolsClientSection' )
            ->where( 'AdmintoolsClientSection.ClientNo = ?', $this->getClientNo( ) )
            ->find( )
            ->toKeyValue( 'SectionId', 'SectionName' );
    }

    public function getPassword( )
    {
        return $this->api_client->getAuthKey( );
    }

    public function getSalt( )
    {
        return false;
    }
    public function getUsername( )
    {
        return $this->getClientNo( );
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
        return $this->api_client;
    }

    public function getClient( ) {
        return $this->api_client->getClient( );
    }

    public function getClientNo( )
    {
        return $this->api_client->getClientNo( );
    }

    public function getAuthKey( )
    {
        return $this->api_client->getAuthKey( );
    }

    public function getIpPermissions( $includeUniversal = true )
    {
        $address = $_SERVER['REMOTE_ADDR'];
        $decaddress = sprintf( '%u', ip2long( $address ) );
        if ( $includeUniversal )
        {
            $query = AllClientValidIpRangesQuery::create( 't' );
        }
        else
        {
            $query = ApiClientValidIpRangesQuery::create( 't' );
        }
        return $query
            ->filterByClientNo( $this->getClientNo( ) )
            ->where( 't.IpDecRangeStart <= ?', $decaddress )
            ->where( 't.IpDecRangeEnd >= ?', $decaddress )
            ->orderByIpRangeSize( )
            ->orderByIpDecRangeStart( )
            ->findOne( );
    }
}

