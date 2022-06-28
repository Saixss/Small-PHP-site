<?php


namespace src\Repository\Category;


use database\ORM\Repository\RepositoryInterface;
use src\Data\DTO\CategoryDTO;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getAll(): \Generator;
}