<?php


namespace core\Encryption;


abstract class EncryptionServiceAbstract implements EncryptionServiceInterface
{

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}