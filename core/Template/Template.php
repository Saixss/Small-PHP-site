<?php


namespace core\Template;


class Template implements TemplateInterface
{
    private const TEMPLATE_DIRECTORY = "templates/";
    private const TEMPLATE_EXTENSION = ".php";
    private const TEMPLATE_HEADER_DIRECTORY = "templates/common/header";
    private const TEMPLATE_FOOTER_DIRECTORY = "templates/common/footer";

    public function render(string $templateName, array $data = [], bool $isLogged = null, $error = null): void
    {
        require_once self::TEMPLATE_HEADER_DIRECTORY .
            self::TEMPLATE_EXTENSION;
        require_once self::TEMPLATE_DIRECTORY .
            $templateName .
            self::TEMPLATE_EXTENSION;
        require_once self::TEMPLATE_FOOTER_DIRECTORY .
            self:: TEMPLATE_EXTENSION;
    }
}