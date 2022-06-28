<?php


namespace src\Repository\User;


use database\ORM\Repository\RepositoryInterface;
use src\Data\DTO\UserDTO;
use src\Data\Entity\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function insert(User $user): void;

    public function getUserByUsername(string $username): ?UserDTO;

    public function edit(int $id, User $user): bool;

    public function getUserById(int $userId): UserDTO;
}