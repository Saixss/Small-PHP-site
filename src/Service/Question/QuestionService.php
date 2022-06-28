<?php


namespace src\Service\Question;


use core\Exception\RouteException;
use src\Data\DTO\QuestionDTO;
use src\Data\Entity\Question;
use src\Data\Exception\QuestionException;
use src\Repository\Question\QuestionRepositoryInterface;

class QuestionService implements QuestionServiceInterface
{
    private QuestionRepositoryInterface $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getQuestions(): \Generator | QuestionDTO
    {
        return $this->questionRepository->getAll();
    }

    /**
     * @param string $categoryName
     * @return \Generator|QuestionDTO
     * @throws RouteException
     */
    public function getQuestionsByCategoryName(string $categoryName): \Generator | QuestionDTO
    {
        $result = $this->questionRepository->getQuestionsByCategoryName($categoryName);

        if ($result->valid() === false) {
            throw new RouteException();
        }

        return $result;
    }

    /**
     * @throws RouteException
     */
    public function getQuestionById(int $id, bool $populateNavigationProp = true): QuestionDTO
    {
        $question = $this->questionRepository->findOne(["id" => $id], $populateNavigationProp, ["answers" => ["created_on" => "DESC"]]);

        if ($question === null) {
            throw new RouteException();
        }

        return $question;
    }

    /**
     * @param Question $question
     * @throws QuestionException
     */
    public function insert(Question $question): void
    {
        if (strlen($question->getTitle()) > 255) {
            throw new QuestionException("Question title max length is 255 syllables");
        }

        if (strlen($question->getTitle()) < 4) {
            throw new QuestionException("Question title min length is 4 syllables");
        }

        if (strlen($question->getBody()) > 2000) {
            throw new QuestionException("Question body max length is 2000 syllables");
        }

        if (strlen($question->getBody()) < 4) {
            throw new QuestionException("Question body min length is 4 syllables");
        }

        $this->questionRepository->insert($question);
    }
}