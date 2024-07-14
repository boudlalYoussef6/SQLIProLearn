<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Ldap\Security\LdapUser as BaseLdapUser;

/**
 * This class is used to customize the default LdapUser.
 */
class LdapUser extends BaseLdapUser
{
}
