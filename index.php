<?php

try {
    session_start();

    spl_autoload_register();

    $config = parse_ini_file("config\config.ini");
    $routes = parse_ini_file("config\\routes.ini");

    $root = $config["root"];

    $uri = $_SERVER["REQUEST_URI"];

    $request = str_replace("/" . $root . "/", "", $uri);
    $requestTokens = explode("/", $request);

    array_shift($requestTokens);
    $params = $requestTokens;

    $routeParser = new \core\Mvc\RouteParser($request, $routes);
    $route = $routeParser->getRoute();

    $controllerName = ucfirst(array_shift($route));
    $controllerFullPathName = $config["controllers_path"] . $controllerName . "\\" . $controllerName . "Controller";
    $actionName = array_shift($route);

    $mvc = new \core\Mvc\MvcContext($controllerFullPathName, $actionName, $params, $request);

    $app = new \core\Application($mvc);

    $app->registerDependency(\database\DatabaseInterface::class, \database\PDODatabase::class);
    $app->registerDependency(\database\ORM\QueryBuilder\QueryBuilderInterface::class, \database\ORM\QueryBuilder\MySQLQueryBuilder::class);

    $app->registerDependency(\core\Template\TemplateInterface::class, \core\Template\Template::class);
    $app->registerDependency(\core\DataBinder\DataBinderInterface::class, \core\DataBinder\DataBinder::class);

    $app->registerDependency(\src\Repository\User\UserRepositoryInterface::class, \src\Repository\User\UserRepository::class);
    $app->registerDependency(\src\Repository\Category\CategoryRepositoryInterface::class, \src\Repository\Category\CategoryRepository::class);
    $app->registerDependency(\src\Repository\Answer\AnswerRepositoryInterface::class, \src\Repository\Answer\AnswerRepository::class);
    $app->registerDependency(\src\Repository\Question\QuestionRepositoryInterface::class, \src\Repository\Question\QuestionRepository::class);

    $app->registerDependency(\src\Service\User\UserServiceInterface::class, \src\Service\User\UserService::class);
    $app->registerDependency(\core\Encryption\EncryptionServiceInterface::class, \core\Encryption\ArgonEncryptionService::class);
    $app->registerDependency(\src\Service\Category\CategoryServiceInterface::class, \src\Service\Category\CategoryService::class);
    $app->registerDependency(\src\Service\Answer\AnswerServiceInterface::class, \src\Service\Answer\AnswerService::class);
    $app->registerDependency(\src\Service\Question\QuestionServiceInterface::class, \src\Service\Question\QuestionService::class);

    $app->start();

} catch (\core\Exception\RouteException $routeException) {
    $isLogged = $_SESSION["user_id"] ?? null;
    require_once "templates/common/header.php";
    require_once "page_not_found_404.php";
    require_once "templates/common/footer.php";
}
//catch (Exception | Error $error) {
//    require_once "something_went_wrong_500.php";
//}