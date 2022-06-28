<?php


namespace src\Repository\Question;


use database\ORM\QueryBuilder\QueryBuilderInterface;
use database\ORM\Repository\AbstractRepository;
use src\Data\DTO\CategoryDTO;
use src\Data\DTO\QuestionDTO;
use src\Data\Entity\Question;
use src\Repository\Answer\AnswerRepositoryInterface;
use src\Repository\Category\CategoryRepositoryInterface;

class QuestionRepository extends AbstractRepository implements QuestionRepositoryInterface
{

    public function __construct(QueryBuilderInterface $queryBuilder)
    {
        parent::__construct
        (
            $queryBuilder,
            QuestionDTO::class,
            "questions",
            "id",
            ["category", "user"],
            ["answers"]
        );
    }

    public function getAll(): \Generator | QuestionDTO
    {
        return $this
            ->queryBuilder
            ->select
            (
                [
                    "q.id",
                    "q.title",
                    "q.body",
                    "q.category_id",
                    "c.name AS categoryName",
                    "u.username",
                    "u.profile_picture_url",
                    "q.created_on",
                    $this->queryBuilder->count("a.id") . " AS answers_count"
                ]
            )
            ->from("questions q")
            ->innerJoin
            (
                "categories c",
                [
                    "q.category_id" => "c.id"
                ]
            )
            ->innerJoin
            (
                "users u",
                [
                    "q.user_id" => "u.id"
                ]
            )
            ->leftJoin
            (
                "answers a",
                [
                    "q.id" => "a.question_id"
                ]
            )
            ->groupBy
            (
                [
                    "q.id",
                    "q.title",
                    "q.body",
                    "q.category_id",
                    "q.user_id",
                    "q.created_on",
                    "a.question_id"
                ]
            )
            ->orderBy(["q.created_on" => "DESC"])
            ->build(true)
            ->fetchAll(QuestionDTO::class);
    }

    public function getQuestionsByCategoryName(string $categoryName): \Generator|QuestionDTO
    {
        return $this
            ->queryBuilder
            ->select
            (
                [
                    "q.id",
                    "q.title",
                    "q.body",
                    "q.category_id",
                    "c.name AS categoryName",
                    "q.created_on",
                    "u.username",
                    "u.profile_picture_url",
                    $this->queryBuilder->count("a.id") . " AS answers_count"
                ]
            )
            ->from("questions q")
            ->innerJoin
            (
                "categories c",
                [
                    "q.category_id" => "c.id"
                ]
            )
            ->innerJoin
            (
                "users u",
                ["q.user_id" => "u.id"]
            )
            ->leftJoin
            (
                "answers a",
                [
                    "q.id" => "a.question_id"
                ]
            )
            ->where(["c.name" => $categoryName])
            ->groupBy
            (
                [
                    "q.id",
                    "q.title",
                    "q.body",
                    "q.category_id",
                    "c.name",
                    "q.created_on",
                    "u.username",
                    "u.profile_picture_url",
                    "a.question_id"
                ]
            )
            ->orderBy(["q.created_on" => "DESC"])
            ->build(true)
            ->fetchAll(QuestionDTO::class);
    }

    public function insert(Question $question): void
    {
        $this
            ->queryBuilder
            ->insert
            (
                "questions",
                [
                    "title" => $question->getTitle(),
                    "body" => $question->getBody(),
                    "category_id" => $question->getCategoryId(),
                    "user_id" => $question->getUserId()
                ]
            );
    }
}