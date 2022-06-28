<?php


namespace src\Service\User;


use src\Data\DTO\UserDTO;
use src\Data\Entity\User;

interface UserServiceInterface
{
    public function register(User $user, string $confirmPassword): void;

    public function login(string $username, string $password): UserDTO;

    public function edit(int $id, User $data): bool;

    public function getUserById(int $userId): UserDTO;
}