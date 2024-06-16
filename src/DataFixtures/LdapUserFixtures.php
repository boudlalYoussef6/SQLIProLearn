<?php

declare(strict_types=1); // Force l'utilisation des types stricts dans ce fichier PHP

namespace App\DataFixtures; // Déclare l'espace de noms de la classe

use Doctrine\Bundle\FixturesBundle\Fixture; // Importe la classe Fixture de Doctrine
use Doctrine\Persistence\ObjectManager; // Importe l'interface ObjectManager de Doctrine
use Symfony\Component\Ldap\Entry; // Importe la classe Entry de Symfony LDAP
use Symfony\Component\Ldap\Ldap; // Importe la classe Ldap de Symfony LDAP

class LdapUserFixtures extends Fixture // Déclare la classe LdapUserFixtures qui hérite de Fixture
{
    public function load(ObjectManager $manager) // La méthode load est appelée pour charger les fixtures
    {
        // Création de la connexion LDAP
        // $ldap = Ldap::create('ext_ldap', ['connection_string' => 'ldap://openldap:389']);
        // $ldap->bind('cn=admin,dc=ramhlocal,dc=com', 'admin_pass'); // Authentifie l'utilisateur admin sur le serveur LDAP

        // Obtention du gestionnaire d'entrées LDAP
        // $entryManager = $ldap->getEntryManager();
        // $entries = [
        //     new Entry(
        //         'cn=johndoe,ou=people,dc=ramhlocal,dc=com', // DN de l'entrée LDAP
        //         [
        //             'objectClass' => ['inetOrgPerson', 'posixAccount'], // Classes d'objet pour cette entrée
        //             'sn' => ['Doe'], // Nom de famille
        //             'givenName' => ['John'], // Prénom
        //             'cn' => ['johndoe'], // Nom commun
        //             'mail' => ['johndoe@sf4app.org'], // Adresse e-mail
        //             'uidNumber' => ['1002'], // Numéro UID
        //             'gidNumber' => ['1002'], // Numéro GID
        //             'homeDirectory' => ['/home/johndoe'], // Répertoire personnel
        //             'uid' => ['johndoe'], // UID
        //             'userPassword' => ['password123'], // Mot de passe utilisateur
        //         ]
        //     ),
        //     new Entry(
        //         'cn=alexsmith,ou=people,dc=ramhlocal,dc=com',
        //         [
        //             'objectClass' => ['inetOrgPerson', 'posixAccount'],
        //             'sn' => ['Smith'],
        //             'givenName' => ['Alex'],
        //             'cn' => ['alexsmith'],
        //             'mail' => ['alexsmith@sf4app.org'],
        //             'uidNumber' => ['1004'],
        //             'gidNumber' => ['1004'],
        //             'homeDirectory' => ['/home/alexsmith'],
        //             'uid' => ['alexsmith'],
        //             'userPassword' => ['password123'],
        //         ]
        //     ),
        //     new Entry(
        //         'cn=maryjohnson,ou=people,dc=ramhlocal,dc=com',
        //         [
        //             'objectClass' => ['inetOrgPerson', 'posixAccount'],
        //             'sn' => ['Johnson'],
        //             'givenName' => ['Mary'],
        //             'cn' => ['maryjohnson'],
        //             'mail' => ['maryjohnson@sf4app.org'],
        //             'uidNumber' => ['1005'],
        //             'gidNumber' => ['1005'],
        //             'homeDirectory' => ['/home/maryjohnson'],
        //             'uid' => ['maryjohnson'],
        //             'userPassword' => ['password123'],
        //         ]
        //     ),
        // ];

        // Ajout des entrées au serveur LDAP
        // foreach ($entries as $entry) {
        //     $entryManager->add($entry);
        // }
    }
}
