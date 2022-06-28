<?php


namespace src\Service\Answer;


use src\Data\Entity\Answer;

interface AnswerServiceInterface
{
    public function insert(Answer $answer): void;
}