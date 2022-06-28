<?php


namespace src\Service\Category;


use src\Data\DTO\CategoryDTO;

interface CategoryServiceInterface
{
    public function getAll(): \Generator | CategoryDTO;

    public function getById(int $id, $populateNavigationProp = true): CategoryDTO;

    public function getByName(string $name, $populateNavigationProp = true): CategoryDTO;
}