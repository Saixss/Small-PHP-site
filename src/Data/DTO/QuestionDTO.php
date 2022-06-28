<?php


namespace src\Data\DTO;


class QuestionDTO
{
    private int $id;

    private string $title;

    private string $body;

    private int $categoryId;

    private string $categoryName;

    private int $userId;

    private string $username;

    private ?string $profilePictureUrl;

    /** @var UserDTO */
    private UserDTO $user;

    /** @var AnswerDTO[] | \Generator */
    private \Generator|array $answers;

    /** @var CategoryDTO $category */
    private CategoryDTO $category;

    private string $createdOn;

    private int $answersCount;

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
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    /**
     * @param string $categoryName
     */
    public function setCategoryName(string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return ?string
     */
    public function getProfilePictureUrl(): ?string
    {
        return $this->profilePictureUrl;
    }

    /**
     * @param ?string $profilePictureUrl
     */
    public function setProfilePictureUrl(?string $profilePictureUrl): void
    {
        $this->profilePictureUrl = $profilePictureUrl;
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
     * @return AnswerDTO[] | \Generator
     */
    public function getAnswers(): array | \Generator
    {
        return $this->answers;
    }

    /**
     * @param AnswerDTO[] | \Generator $answers
     */
    public function setAnswers(array | \Generator $answers): void
    {
        $this->answers = $answers;
    }

    /**
     * @return CategoryDTO
     */
    public function getCategory(): CategoryDTO
    {
        return $this->category;
    }

    /**
     * @param CategoryDTO $category
     */
    public function setCategory(CategoryDTO $category): void
    {
        $this->category = $category;
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

    /**
     * @return int
     */
    public function getAnswersCount(): int
    {
        return $this->answersCount;
    }

    /**
     * @param int $answersCount
     */
    public function setAnswersCount(int $answersCount): void
    {
        $this->answersCount = $answersCount;
    }
}