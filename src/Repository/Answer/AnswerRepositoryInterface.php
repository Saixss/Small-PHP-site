<?php


namespace src\Repository\Answer;


use database\ORM\Repository\RepositoryInterface;
use src\Data\DTO\AnswerDTO;
use src\Data\Entity\Answer;

interface AnswerRepositoryInterface extends RepositoryInterface
{
    public function insert(Answer $answer): void;
}