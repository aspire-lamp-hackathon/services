<?php
/**
 * UserProvider
 *
 * Provides (emulated) user level security for APIs
 *
 * @copyright:  Aria Systems, Inc.
 * @author:     David Morfin
 * @version:    $Rev: 7490 $
 */

namespace Aria\CoreBundle\Security\User;

use Propel\PropelBundle\Security\User\ModelUserProvider;

class DashboardUserProvider extends ModelUserProvider
{
    public function __construct( )
    {
        parent::__construct(
            'Aria\DataBundle\Model\WebCore\DashboardUser', 
            'Aria\CoreBundle\Security\User\DashboardUserProxy', 
            'userId'
        );
    }
}

