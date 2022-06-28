<?php


namespace core\Template;


interface TemplateInterface
{
    public function render(string $templateName, array $data = [], bool $isLogged = null, $error = null): void;
}