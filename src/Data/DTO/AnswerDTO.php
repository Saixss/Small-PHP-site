<?php


namespace src\Data\DTO;


class AnswerDTO
{
    private int $id;

    private string $body;

    private string $userId;

    private string $title;

    private QuestionDTO $question;

    private UserDTO $user;

    private string $questionId;

    private int $daysOld;

    private string $createdOn;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    /**
     * @return QuestionDTO
     */
    public function getQuestion(): QuestionDTO
    {
        return $this->question;
    }

    /**
     * @param QuestionDTO $question
     */
    public function setQuestion(QuestionDTO $question): void
    {
        $this->question = $question;
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {
        return $this->user;
    }

    /**
     * @param UserDTO $user
     */
    public function setUser(UserDTO $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    /**
     * @param string $questionId
     */
    public function setQuestionId(string $questionId): void
    {
        $this->questionId = $questionId;
    }

    /**
     * @return int
     */
    public function getDaysOld(): int
    {
        return $this->daysOld;
    }

    /**
     * @param int $daysOld
     */
    public function setDaysOld(int $daysOld): void
    {
        $this->daysOld = $daysOld;
    }

    /**
     * @return string
     */
    public function getCreatedOn(): string
    {
        return $this->createdOn;
    }

    /**
     * @param string $createdOn
     */
    public function setCreatedOn(string $createdOn): void
    {
        $this->createdOn = $createdOn;
    }
}