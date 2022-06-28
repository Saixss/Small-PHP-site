<?php


namespace src\Repository\Answer;


use database\ORM\QueryBuilder\QueryBuilderInterface;
use database\ORM\Repository\AbstractRepository;
use src\Data\DTO\AnswerDTO;
use src\Data\Entity\Answer;
use src\Repository\Question\QuestionRepositoryInterface;

class AnswerRepository extends AbstractRepository implements AnswerRepositoryInterface
{

    public function __construct(QueryBuilderInterface $queryBuilder)
    {
        parent::__construct
        (
            $queryBuilder,
            AnswerDTO::class,
            "answers",
            "id",
            ["question", "user"]
        );
    }

    public function insert(Answer $answer): void
    {
        $this
            ->queryBuilder
            ->insert
            (
                "answers",
                [
                    "body" => $answer->getBody(),
                    "user_id" => $answer->getAuthorId(),
                    "question_id" => $answer->getQuestionId()
                ]
            );
    }
}