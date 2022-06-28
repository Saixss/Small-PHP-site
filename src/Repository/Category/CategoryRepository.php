<?php


namespace src\Repository\Category;


use database\ORM\QueryBuilder\QueryBuilderInterface;
use database\ORM\Repository\AbstractRepository;
use src\Data\DTO\CategoryDTO;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{

    public function __construct(QueryBuilderInterface $queryBuilder)
    {
        parent::__construct(
            $queryBuilder,
            CategoryDTO::class,
            "categories",
            "id",
            [],
            ["questions"]
        );
    }

    public function getAll(): \Generator
    {
        return $this
            ->queryBuilder
            ->select
            (
                [
                    "c.id",
                    "c.name",
                    $this->queryBuilder->count("q.id") . " AS questions_count"
                ]
            )
            ->from("categories c")
            ->leftJoin
            (
                "questions q",
                ["c.id" => "q.category_id"]
            )
            ->groupBy(["c.id", "c.name"])
            ->build()
            ->fetchAll(CategoryDTO::class);
    }
}