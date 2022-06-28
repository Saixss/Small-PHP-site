<?php


namespace src\Controller\User;



interface UserControllerInterface
{
    public function register(): void;

    public function login(): void;

    public function profile(): void;

    public function logout(): void;
}