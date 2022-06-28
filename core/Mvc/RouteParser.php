<?php


namespace core\Mvc;


use core\Exception\RouteException;

class RouteParser
{
    private string $requestRoute;

    private array $routes;

    public function __construct(string $requestRoute, array $routes)
    {
        $this->requestRoute = $requestRoute;
        $this->routes = $routes;
    }

    /**
     * @return array
     * @throws RouteException
     */
    public function getRoute(): array
    {
        $route = "";

        if ($this->requestRoute === "") {
            $this->requestRoute = $this->routes["default_route"];
        }

        if (str_contains($this->requestRoute, "/")) {
            $this->requestRoute = explode("/", $this->requestRoute)[0];
        }

        foreach ($this->routes as $controllerAction => $signedRoute) {

            if ($signedRoute === $this->requestRoute) {
                $route = $controllerAction;
            }
        }

        if ($route === "") {
            throw new RouteException($this->requestRoute);
        }

        return explode("/", $route);
    }
}