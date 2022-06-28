<?php


namespace src\Repository\User;


use database\DatabaseInterface;
use database\ORM\QueryBuilder\QueryBuilderInterface;
use database\ORM\Repository\AbstractRepository;
use src\Data\DTO\UserDTO;
use src\Data\Entity\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    public function __construct(QueryBuilderInterface $queryBuilder)
    {
        parent::__construct(
            $queryBuilder,
            UserDTO::class,
            "users",
            "id"
        );
    }

    public function insert(User $user): void
    {
        $this->queryBuilder
            ->insert
            ("users",
                [
                    "username" => $user->getUsername(),
                    "password" => $user->getPassword(),
                    "first_name" => $user->getFirstName(),
                    "last_name" => $user->getLastName(),
                    "born_on" => $user->getBornOn()
                ]
            );
    }

    public function getUserByUsername(string $username): ?UserDTO
    {
        return $this
            ->queryBuilder
            ->select
            (
                ["id", "username", "password", "first_name", "last_name", "born_on"]
            )
            ->from
                ("users")
            ->where
                (["username" => $username])
            ->build()
            ->fetch(UserDTO::class);
    }

    public function edit(int $id, User $user): bool
    {
        return $this
            ->queryBuilder
            ->update
            (
            "users",
                [
                    "username" => $user->getUsername(),
                    "first_name" => $user->getFirstName(),
                    "last_name" => $user->getLastName(),
                    "born_on" => $user->getBornOn(),
                    "profile_picture_url" => $user->getProfilePictureUrl()
                ],
                [
                    "id" => $id
                ]
            )
            ->getExecuteSuccess();
    }

    public function getUserById(int $userId): UserDTO
    {
        return $this
            ->queryBuilder
            ->select
            (
                ["id", "username", "password", "first_name", "last_name", "born_on", "profile_picture_url"]
            )
            ->from
                ("users")
            ->where
                (["id" => $userId])
            ->build()
            ->fetch(UserDTO::class);
    }
}