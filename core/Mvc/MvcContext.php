<?php


namespace core\Mvc;


use core\Exception\RouteException;

class MvcContext implements MvcContextInterface
{
    private string $controllerName;

    private string $actionName;

    private array $params;

    private string $requestPath;


    public function __construct(string $controllerName, string $actionName, array $params, string $requestPath)
    {
        $this->setControllerName($controllerName);
        $this->setActionName($actionName);
        $this->setParams($params);
        $this->setRequestPath($requestPath);
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     */
    public function setControllerName(string $controllerName): void
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName(string $actionName): void
    {
        $this->actionName = $actionName;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $hasEmptyString = false;

        foreach ($params as $key => $param) {
            $params[$key] = urldecode($param);

            if (empty($param)) {
                unset($params[$key]);
            }

            if (str_contains($param, "?")) {
                unset($params[$key]);
            }
        }

        $params = array_values($params);

        if ($hasEmptyString === true) {
            $this->params = [];
        } else {
            $this->params = $params;
        }
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->requestPath;
    }

    /**
     * @param string $requestPath
     */
    public function setRequestPath(string $requestPath): void
    {
        $this->requestPath = $requestPath;
    }
}