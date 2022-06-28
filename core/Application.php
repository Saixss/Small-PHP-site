<?php


namespace core;


use Cassandra\Varint;
use core\DataBinder\DataBinder;
use core\Exception\RouteException;
use core\Mvc\MvcContextInterface;
use ReflectionNamedType;

class Application
{
    /**
     * @var MvcContextInterface
     */
    private MvcContextInterface $mvcContext;

    /**
     * @var array
     */
    private array $dependencies = [];

    /**
     * @var array
     */
    private array $resolvedDependencies = [];

    /**
     * Application constructor.
     * @param MvcContextInterface $mvcContext
     */
    public function __construct(MvcContextInterface $mvcContext)
    {
        $this->mvcContext = $mvcContext;
    }

    /**
     * @throws RouteException
     * @throws \ReflectionException
     */
    public function start()
    {
        $controllerName = $this->mvcContext->getControllerName();
        $actionName = $this->mvcContext->getActionName();

        $controller = $this->resolve($controllerName);

        $refMethod = new \ReflectionMethod($controller, $actionName);

        $refParams = $refMethod->getParameters();

        $this->resolveMethods($refParams);

        call_user_func_array([$controller, $actionName], $this->mvcContext->getParams());
    }

    /**
     * Populates classes with their dependencies
     *
     * @param string $className
     * @return object
     * @throws \ReflectionException
     */
    private function resolve(string $className): object
    {
        if (array_key_exists($className, $this->resolvedDependencies)) {

            return $this->resolvedDependencies[$className];
        }

        $refClass = new \ReflectionClass($className);
        $constructor = $refClass->getConstructor();

        if($constructor === null) {

            $object = new $className;
            $this->resolvedDependencies[$className] = $object;
            return $object;
        }

        $parameters = $constructor->getParameters();
        $arguments = [];

        foreach ($parameters as $parameter) {

            if ($parameter->getClass()) {
                $dependencyInterface = $parameter->getClass();
                $dependencyClass = $this->dependencies[$dependencyInterface->getName()];
                $arguments[] = $this->resolve($dependencyClass);
            }
        }

        $object = $refClass->newInstanceArgs($arguments);
        $this->resolvedDependencies[$className] = $object;

        return $object;
    }

    /**
     * Populates class methods with their dependencies.
     * If the dependency does not exist in the register,
     * binds the post data to its respective model
     *
     * @param \ReflectionParameter[] $refParams
     * @throws \ReflectionException|RouteException
     */
    private function resolveMethods(array $refParams)
    {
        $urlParamsCount = count($this->mvcContext->getParams());

        $this->validateParams($refParams);

        for ($i = $urlParamsCount; $i < count($refParams); $i++) {
            $argument = $refParams[$i];

            $argumentInterface = $argument->getClass();

            if (isset($argumentInterface) === false) {
                continue;
            }

            $argumentInterface = $argumentInterface->getName();

            if (array_key_exists($argumentInterface, $this->dependencies)) {
                $argumentClass = $this->dependencies[$argumentInterface];
                $this->mvcContext->setParams($this->resolve($argumentClass));
            }
//            else {
//                $dataBinder = new DataBinder();
//
//                $bindingModel = $dataBinder->bind($_POST, $argumentInterface);
//                $this->mvcContext->setParams($bindingModel);
//            }
        }
    }

    /**
     * Compares the number of passed and expected parameters.
     * If they differ throws RouteException.
     *
     * Checks if the url parameters and method parameters are both int.
     * If one is int and the other is not, throws RouteException
     *
     * @param \ReflectionParameter[] $refParams
     * @throws RouteException
     */

    private function validateParams(array $refParams)
    {
        $urlParamsCount = count($this->mvcContext->getParams());

        if (count($refParams) > $urlParamsCount) {

            for ($i = $urlParamsCount; $i < count($refParams); $i++) {
                $argument = $refParams[$i];

                $argumentInterface = $argument->getClass();

                if (isset($argumentInterface) === false) {

                    if ($argument->getType()->allowsNull() === false) {
                        throw new RouteException();
                    }
                }
            }
        }

        if (count($this->mvcContext->getParams()) !== 0) {

            for ($i = 0; $i < count($refParams); $i++) {

                if (is_numeric($this->mvcContext->getParams()[$i]) === true) {
                    if($refParams[$i]->getType()->getName() !== "int") {
                        throw new RouteException($this->mvcContext->getRequestPath());
                    }
                }

                if ($refParams[$i]->getType()->getName() === "int") {
                    if(is_numeric($this->mvcContext->getParams()[$i]) !== true) {
                        throw new RouteException($this->mvcContext->getRequestPath());
                    }
                }
            }
        }
    }

    /**
     * @param string $abstraction
     * @param string $implementation
     */
    public function registerDependency(string $abstraction, string $implementation)
    {
        $this->dependencies[$abstraction] = $implementation;
    }
}