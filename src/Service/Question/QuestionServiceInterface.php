<?php


namespace src\Service\Question;


use src\Data\DTO\QuestionDTO;
use src\Data\Entity\Question;

interface QuestionServiceInterface
{
    public function getQuestions(): \Generator | QuestionDTO;

    public function getQuestionsByCategoryName(string $categoryName): \Generator | QuestionDTO;

    public function getQuestionById(int $id, bool $populateNavigationProp = true): QuestionDTO;

    public function insert(Question $question): void;
}