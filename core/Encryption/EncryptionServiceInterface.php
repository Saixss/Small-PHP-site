<?php


namespace core\Encryption;


interface EncryptionServiceInterface
{
    public function hash(string $plainPassword): string;

    public function verify(string $password, string $hash): bool;
}