<?php


namespace core\Mvc;


interface MvcContextInterface
{
    public function getControllerName(): string;

    public function setControllerName(string $controllerName): void;

    public function getActionName(): string;

    public function setActionName(string $actionName): void;

    public function getParams(): array;

    public function setParams(array $params): void;

    public function getRequestPath(): string;

    public function setRequestPath(string $requestPath): void;
}