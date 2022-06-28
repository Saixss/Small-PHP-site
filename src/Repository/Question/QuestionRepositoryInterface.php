<?php


namespace src\Repository\Question;


use database\ORM\Repository\RepositoryInterface;
use src\Data\DTO\CategoryDTO;
use src\Data\DTO\QuestionDTO;
use src\Data\Entity\Question;

interface QuestionRepositoryInterface extends RepositoryInterface
{
    public function getAll(): \Generator | QuestionDTO;

    public function getQuestionsByCategoryName(string $categoryName): \Generator | QuestionDTO;

    public function insert(Question $question): void;
}