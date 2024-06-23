<?php

declare(strict_types=1);

namespace App\Security\PasswordHasher;

use App\Security\PasswordHasher\Algorithm\HashingAlgorithmInterface;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\CheckPasswordLengthTrait;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class PasswordHasher implements PasswordHasherInterface
{
    use CheckPasswordLengthTrait;

    public function __construct(private readonly HashingAlgorithmInterface $encoder)
    {
    }

    public function hash(#[\SensitiveParameter] string $plainPassword): string
    {
        if ($this->isPasswordTooLong($plainPassword)) {
            throw new InvalidPasswordException();
        }

        return $this->encoder->encrypt($plainPassword);
    }

    public function verify(string $hashedPassword, #[\SensitiveParameter] string $plainPassword): bool
    {
        if ('' == $plainPassword || $this->isPasswordTooLong($plainPassword)) {
            return false;
        }

        return $this->encoder->verify($hashedPassword, $plainPassword);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }
}
