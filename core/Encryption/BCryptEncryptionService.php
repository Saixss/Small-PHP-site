<?php


namespace core\Encryption;


class BCryptEncryptionService extends EncryptionServiceAbstract
{

    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }
}