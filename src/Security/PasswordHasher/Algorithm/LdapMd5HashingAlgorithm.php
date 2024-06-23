<?php

declare(strict_types=1);

namespace App\Security\PasswordHasher\Algorithm;

class LdapMd5HashingAlgorithm implements HashingAlgorithmInterface
{
    public function encrypt(#[\SensitiveParameter] string $clearText): string
    {
        return \sprintf('{MD5}%s', \base64_encode(\pack('H*', \md5($clearText))));
    }

    public function verify(string $encryptedInputText, #[\SensitiveParameter] string $clearInputText): bool
    {
        return \strcasecmp($this->encrypt($clearInputText), $encryptedInputText) == 0;
    }
}
