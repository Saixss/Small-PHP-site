<?php


namespace src\Controller\User;


use core\DataBinder\DataBinderInterface;
use core\Template\TemplateInterface;
use core\Controller\BaseControllerAbstract;
use JetBrains\PhpStorm\Pure;
use src\Data\Entity\User;
use src\Service\User\UserServiceInterface;

class UserController extends BaseControllerAbstract implements UserControllerInterface
{

    #[Pure] public function __construct(TemplateInterface $template, DataBinderInterface $dataBinder, UserServiceInterface $userService)
    {
        parent::__construct($template, $dataBinder, $userService);
    }

    public function register(): void
    {
        if ($this->isLogged()) {
            $this->redirect("");
        }

        if (isset($_POST["btnRegister"])) {

            try {
                $user = $this->dataBinder->bind($_POST, User::class);
                $this->userService->register($user, $_POST["confirm_password"]);

                $this->redirect("login");
            } catch (\Exception $exception) {
                $this->render("users/register", [], $exception->getMessage());
            }
        }

        $this->render("users/register");
    }

    public function login(): void
    {
        if ($this->isLogged()) {
            $this->redirect("");
        }

        if (isset($_POST["btnLogin"])) {

            try {
                $user = $this->dataBinder->bind($_POST, User::class);
                $username = $user->getUsername();
                $password = $user->getPassword();

                $baseUser = $this->userService->login($username, $password);
                $this->setSessionId($baseUser->getId());

                $this->redirect("");
            } catch (\Exception $exception) {
                $this->render("users/login", [], $exception->getMessage());
            }
        }

        $this->render("users/login");
    }

    public function profile(): void
    {
        if ($this->isLogged() === false) {
            $this->redirect("login");
        }

        $user = $this->getUser();

        if (isset($_POST["btnEdit"])) {

            try {
                $userId = $this->getSessionId();

                $user = $this->dataBinder->bind($_POST, User::class);

                $this->userService->edit($userId, $user);

                $this->redirect("profile");
            } catch (\Exception $exception) {
                $this->render("users/profile", [$user], $exception->getMessage());
            }
        }

        $this->render("users/profile", [$user]);
    }

    public function logout(): void
    {
        $this->destroySession();
        $this->redirect("guest");
    }
}