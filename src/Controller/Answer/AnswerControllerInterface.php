<?php


namespace src\Controller\Answer;


interface AnswerControllerInterface
{
    public function answers(int $questionId): void;
}