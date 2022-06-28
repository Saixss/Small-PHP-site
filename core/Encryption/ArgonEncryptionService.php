<?php


namespace core\Encryption;


class ArgonEncryptionService extends EncryptionServiceAbstract
{

    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_ARGON2I);
    }
}