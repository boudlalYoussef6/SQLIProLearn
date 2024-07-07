<?php

declare(strict_types=1);

namespace App\Security\Provider;

use App\Entity\LdapUser as CustomLdapUser;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Security\LdapUser;
use Symfony\Component\Ldap\Security\LdapUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomLdapUserProvider extends LdapUserProvider
{
    public function supportsClass(string $class): bool
    {
        return CustomLdapUser::class === $class;
    }

    /**
     * Loads a user from an LDAP entry.
     */
    protected function loadUser(string $identifier, Entry $entry): UserInterface
    {
        /** @var LdapUser $baseLdapUser */
        $baseLdapUser = parent::loadUser($identifier, $entry);

        $computedRoles = $this->computeRoles($baseLdapUser);

        return new LdapUser(
            $entry,
            $identifier,
            $baseLdapUser->getPassword(),
            \array_unique(\array_merge($baseLdapUser->getRoles(), $computedRoles)),
            $baseLdapUser->getExtraFields(),
        );
    }

    private function computeRoles(LdapUser $user): array
    {
        $extraFields = $user->getExtraFields();

        return \array_map(function (string $field) {
            $role = \preg_replace('/\s+/', '_', $field);

            return 'ROLE_'.\strtoupper($role);
        }, $extraFields['employeeType'] ?? []);
    }
}
