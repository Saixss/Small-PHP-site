<?php


namespace core\Controller;


use core\DataBinder\DataBinderInterface;
use core\Template\TemplateInterface;
use src\Data\DTO\UserDTO;
use src\Service\User\UserServiceInterface;

abstract class BaseControllerAbstract implements BaseControllerInterface
{
    private TemplateInterface $template;

    protected ?UserServiceInterface $userService;

    protected ?DataBinderInterface $dataBinder;

    public function __construct(TemplateInterface $template, DataBinderInterface $dataBinder = null, UserServiceInterface $userService = null)
    {
        $this->template = $template;
        $this->dataBinder = $dataBinder;
        $this->userService = $userService;
    }

    public function redirect(string $url): void
    {
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/" . parse_ini_file("config/config.ini")["root"] . "/" . $url);
        exit;
    }

    public function render(string $templateName, array $data = [], $error = null): void
    {
        $isLogged = $this->isLogged();

        $this->template->render($templateName, $data, $isLogged, $error);
    }

    public function setSessionId(int $id): void
    {
        $_SESSION["user_id"] = $id;
    }

    public function getSessionId(): ?int
    {
        return $_SESSION["user_id"] ?? null;
    }

    public function destroySession(): void
    {
        unset($_SESSION["user_id"]);
        session_destroy();
    }

    public function isLogged(): bool
    {
        return isset($_SESSION["user_id"]);
    }

    public function getUser(): UserDTO
    {
        return $this->userService->getUserById($this->getSessionId());
    }
}