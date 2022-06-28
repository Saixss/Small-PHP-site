<?php


namespace src\Controller\Question;


interface QuestionControllerInterface
{
    public function questions(?string $categoryName = null): void;

    public function askQuestion(string $categoryName): void;
}