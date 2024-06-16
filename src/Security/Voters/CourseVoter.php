<?php

declare(strict_types=1);

namespace App\Security\Voters;

use App\Entity\Course;
use Symfony\Component\Ldap\Security\LdapUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CourseVoter extends Voter
{
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Course;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof LdapUser) {
            return false;
        }

        /** @var Course $course */
        $course = $subject;

        return match ($attribute) {
            self::EDIT, self::DELETE => $course->getAuthor()?->getName() === $user->getUserIdentifier(),
            default => false,
        };
    }
}
