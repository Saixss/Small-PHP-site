<?php


namespace core\Controller;


use src\Data\DTO\UserDTO;

interface BaseControllerInterface
{
    public function redirect(string $url): void;

    public function render(string $templateName, array $data = [], $error = null): void;

    public function setSessionId(int $id): void;

    public function getSessionId(): ?int;

    public function destroySession(): void;

    public function isLogged(): bool;

    public function getUser(): UserDTO;
}