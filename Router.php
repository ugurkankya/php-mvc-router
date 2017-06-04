<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 04.06.2017
 * @PHP MVC Ready Routing Implementation
 */

class Router implements RouterInterface
{
    /**
     * @var $_currentRequest
     */
    protected $_currentRequest;
    /**
     * @var $_requestSeparator
     */
    protected $_requestSeparator;
    /**
     * @var $_routes
     */
    protected $_routes = [];

    /**
     * Build the __construct()
     * @param $currentRequest
     * @param string $requestSeparator
     */
    public function __construct($currentRequest, $requestSeparator = "/")
    {
        $this->_currentRequest = $currentRequest;
        $this->_requestSeparator = $requestSeparator;
    }

    /**
     * Add the route to the array.
     * @param $routeName
     * @param $routeExpression
     * @param $routeController
     * @param $routeMethod
     * @return bool
     */
    public function addRoute($routeName, $routeExpression, $routeController, $routeMethod): bool
    {
        if ($this->routeExists($routeName)) {
            throw new LogicException($routeName . "\n already exists.");
        }

        $routeName = empty($routeName) || $routeName == "/" ? "index" : $routeName;

        $this->_routes[$routeName] = [
            "routeName"       => $routeName,
            "routeExpression" => $routeName. $routeExpression,
            "routeController" => $routeController,
            "routeMethod"     => $routeMethod
        ];

        return true;
    }

    /**
     * Check if the route exists.
     * @param $routeName
     * @return bool
     */
    protected function routeExists($routeName): bool
    {
        return array_key_exists($routeName, $this->_routes);
    }

    /**
     * Get the current request parts.
     * @return array
     */
    protected function getRequestParts(): array
    {
        return array_filter(
            explode($this->_requestSeparator, $this->_currentRequest)
        );
    }

    /**
     * Get the current route parts.
     * @return array
     */
    protected function getRouteParts(): array
    {
        return array_filter(
               explode($this->_requestSeparator, $this->getCurrentRoute()["routeExpression"])
        );
    }

    /**
     * Get the current route params.
     * @return array
     */
    protected function getRouteParams(): array
    {
        return array_diff($this->getRequestParts(), $this->getRouteParts());
    }

    /**
     * Get the expression params.
     * @return array
     */
    protected function getExpressionParams(): array
    {
        preg_match_all('/\{(.*?)\}/', $this->getCurrentRoute()["routeExpression"], $routeParams);

        return $routeParams[1];
    }

    /**
     * Get the current route.
     * @return array
     */
    public function getCurrentRoute(): array
    {
        return $this->_routes[$this->getRequestParts()[1] ?? "index"] ?? null;
    }

    /**
     * Combine all the params.
     * @return array
     */
    public function combineParams(): array
    {
        if (count($this->getRouteParams()) !== count($this->getExpressionParams())) {
            throw new LogicException("Route arguments should be equal.");
        }

        return array_combine($this->getExpressionParams(), $this->getRouteParams());
    }
}