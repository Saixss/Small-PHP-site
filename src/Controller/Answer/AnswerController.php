<?php


namespace src\Controller\Answer;


use core\DataBinder\DataBinderInterface;
use core\Template\TemplateInterface;
use core\Controller\BaseControllerAbstract;
use src\Data\Entity\Answer;
use src\Data\Exception\AnswerException;
use src\Service\Answer\AnswerServiceInterface;
use src\Service\Question\QuestionServiceInterface;

class AnswerController extends BaseControllerAbstract implements AnswerControllerInterface
{
    private AnswerServiceInterface $answerService;

    private QuestionServiceInterface $questionService;

    public function __construct(AnswerServiceInterface $answerService, QuestionServiceInterface $questionService, TemplateInterface $template, DataBinderInterface $dataBinder)
    {
        $this->answerService = $answerService;
        $this->questionService = $questionService;
        parent::__construct($template, $dataBinder);
    }

    public function answers(int $questionId): void
    {
        if ($this->isLogged() === false) {
            $this->redirect("");
        }

        $question = $this->questionService->getQuestionById($questionId);

        $error = "";

        if (isset($_POST["btnAnswer"])) {

            try {
                /** @var Answer $answer */
                $answer = $this->dataBinder->bind($_POST, Answer::class);

                $answer->setQuestionId($question->getId());
                $answer->setAuthorId($this->getSessionId());

                $this->answerService->insert($answer);
            } catch (AnswerException $exception) {
                $error = $exception->getMessage();
            }
        }

        $question->setAnswers(iterator_to_array($question->getAnswers()));

        foreach ($question->getAnswers() as $answer) {
            $commentDate = strtotime($answer->getCreatedOn());
            $currentDate = strtotime(date("Y-m-d"));
            $seconds = $currentDate - $commentDate;
            $days = (int)($seconds / 86400);

            $answer->setDaysOld($days);
        }

        $this->render("answer/answers", ["question" => $question], $error);
    }
}