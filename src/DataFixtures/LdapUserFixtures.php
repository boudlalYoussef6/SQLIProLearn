<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Ldap;

class LdapUserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ldap = Ldap::create('ext_ldap', ['connection_string' => 'ldap://openldap:389']);
        $ldap->bind('cn=admin,dc=ramhlocal,dc=com', 'admin_pass');

        $entryManager = $ldap->getEntryManager();
        $entries = [
            new Entry(
                'cn=newuser,ou=people,dc=ramhlocal,dc=com',
                [
                    'objectClass' => ['inetOrgPerson', 'posixAccount'],
                    'sn' => ['Newuser'],
                    'givenName' => ['New'],
                    'cn' => ['newuser'],
                    'mail' => ['newuser@sf4app.org'],
                    'uidNumber' => ['1001'],
                    'gidNumber' => ['1001'],
                    'homeDirectory' => ['/home/newuser'],
                    'uid' => ['newuser'],
                    'userPassword' => ['password123'],
                ]
            ),
        ];

        foreach ($entries as $entry) {
            $entryManager->add($entry);
        }
    }
}
