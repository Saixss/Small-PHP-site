<?php


namespace src\Controller\Home;


use core\Template\TemplateInterface;
use core\Controller\BaseControllerAbstract;


class HomeController extends BaseControllerAbstract implements HomeControllerInterface
{

    public function __construct(TemplateInterface $template)
    {
        parent::__construct($template);
    }

    public function guest(): void
    {
        if($this->isLogged() === true) {
            $this->redirect("");
        }

        $this->render("guest");
    }
}