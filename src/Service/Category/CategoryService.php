<?php


namespace src\Service\Category;


use core\Exception\RouteException;
use src\Data\DTO\CategoryDTO;
use src\Repository\Category\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface
{
    private CategoryRepositoryInterface $categoryRepository;


    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(): \Generator|CategoryDTO
    {
        return $this->categoryRepository->getAll();
    }

    public function getById(int $id, $populateNavigationProp = true): CategoryDTO
    {
        return $this->categoryRepository->findOne(["id" => $id], $populateNavigationProp);
    }

    /**
     * @throws RouteException
     */
    public function getByName(string $name, $populateNavigationProp = true): CategoryDTO
    {
        $category = $this->categoryRepository->findOne(["name" => $name], $populateNavigationProp);

        if ($category === null) {
            throw new RouteException();
        }

        return $category;
    }
}