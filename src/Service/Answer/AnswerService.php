<?php


namespace src\Service\Answer;


use src\Data\Entity\Answer;
use src\Data\Exception\AnswerException;
use src\Repository\Answer\AnswerRepositoryInterface;

class AnswerService implements AnswerServiceInterface
{
    private AnswerRepositoryInterface $answerRepository;


    public function __construct(AnswerRepositoryInterface $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * @throws AnswerException
     */
    public function insert(Answer $answer): void
    {
        if (strlen($answer->getBody()) > 1000) {
            throw new AnswerException("Answer max length is 1000 characters");
        }

        if (strlen($answer->getBody()) < 1) {
            throw new AnswerException("Answer min length is 1 character");
        }

        $this->answerRepository->insert($answer);
    }
}