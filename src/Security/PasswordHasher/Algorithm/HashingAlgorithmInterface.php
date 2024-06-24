<?php

declare(strict_types=1);

namespace App\Security\PasswordHasher\Algorithm;

interface HashingAlgorithmInterface
{
    public function encrypt(#[\SensitiveParameter] string $clearText): string;

    public function verify(string $encryptedInputText, #[\SensitiveParameter] string $clearInputText): bool;
}
