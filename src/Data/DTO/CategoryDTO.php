<?php


namespace src\Data\DTO;


class CategoryDTO
{
    private int $id;

    private string $name;

    private int $questions_count;

    /** @var QuestionDTO[] $questions */
    private \Generator | array $questions;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getQuestionsCount(): int
    {
        return $this->questions_count;
    }

    /**
     * @param int $questions_count
     */
    public function setQuestionsCount(int $questions_count): void
    {
        $this->questions_count = $questions_count;
    }

    /**
     * @return QuestionDTO[] | \Generator
     */
    public function getQuestions(): \Generator|array
    {
        return $this->questions;
    }

    /**
     * @param QuestionDTO[] $questions
     */
    public function setQuestions(\Generator|array $questions): void
    {
        $this->questions = $questions;
    }
}