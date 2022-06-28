<?php


namespace src\Controller\Question;


use core\DataBinder\DataBinderInterface;
use core\Paginator\Paginator;
use core\Template\TemplateInterface;
use core\Controller\BaseControllerAbstract;
use src\Data\Entity\Question;
use src\Service\Category\CategoryServiceInterface;
use src\Service\Question\QuestionServiceInterface;

class QuestionController extends BaseControllerAbstract implements QuestionControllerInterface
{
    private QuestionServiceInterface $questionService;

    private CategoryServiceInterface $categoryService;

    public function __construct(QuestionServiceInterface $questionService, CategoryServiceInterface $categoryService, TemplateInterface $template, DataBinderInterface $dataBinder)
    {
        $this->questionService = $questionService;
        $this->categoryService = $categoryService;
        parent::__construct($template, $dataBinder);
    }

    public function questions(?string $categoryName = null): void
    {
        if ($this->isLogged() === false) {
            $this->redirect("guest");
        }

        if (isset($categoryName) === false) {
            $questions = $this->questionService->getQuestions();
        } else {

//            $category = $this->categoryService->getByName($categoryName, false);
            $questions = $this->questionService->getQuestionsByCategoryName($categoryName);
        }

        $categories = $this->categoryService->getAll();

        $paginator = new Paginator();

        $this->render
        (
            "question/questions",
            [
                "questions" => $questions,
                "categories" => $categories,
                "categoryName" => $categoryName,
                "paginator" => $paginator
            ]
        );
    }

    public function askQuestion(string $categoryName): void
    {
        if ($this->isLogged() === false) {
            $this->redirect("login");
        }

        $category = $this->categoryService->getByName($categoryName, false);

        if (isset($_POST["btnAsk"])) {

            try {
                /** @var Question $question */

                $question = $this->dataBinder->bind($_POST, Question::class);

                $question->setAuthorId($this->getSessionId());
                $question->setCategoryId($category->getId());

                $this->questionService->insert($question);

                $this->redirect("questions/{$category->getName()}");
            } catch (\Exception $exception) {
                $this->render("question/ask_question", [], $exception->getMessage());
            }
        }

        $this->render("question/ask_question");
    }
}