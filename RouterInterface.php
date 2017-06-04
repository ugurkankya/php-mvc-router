<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 04.06.2017
 * @PHP MVC Ready Routing Implementation
 */
interface RouterInterface {
    /**
     * Add the route to the array.
     * @param $routeName
     * @param $routeExpression
     * @param $routeController
     * @param $routeMethod
     * @return bool
     */
    public function addRoute($routeName, $routeExpression, $routeController, $routeMethod): bool;
    /**
     * Get the current route.
     * @return array
     */
    public function getCurrentRoute(): array;
    /**
     * Combine all the params.
     * @return array
     */
    public function combineParams(): array;
}