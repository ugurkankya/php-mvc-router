# php-mvc-router
PHP MVC Ready Routing Implementation

```php
/**
 * @author : Ugurkan Kaya
 * @date   : 04.06.2017
 * @PHP MVC Ready Routing Implementation
 */

require("vendor/autoload.php");

$router = new Router($_SERVER["REQUEST_URI"]);

$router->addRoute("/",
    null,
    "HomeController",
    "showHome");

$router->addRoute("category",
    "/{name}/page/{page}/order/{order}",
    "CategoryController",
    "showCategory"
);

/**
 * Array
 * (
 * [name] => music
 * [page] => 5
 * [order] => recent
 * )
 */

$router->addRoute("users",
    "/{id}/{name}/{surname}",
    "UserController",
    "showUser"
);

/**
 * Array
 * (
 * [id] => 1
 * [name] => ugurkan
 * [surname] => kaya
 * )
 */


print_r($router->combineParams());

print_r($router->getCurrentRoute());
```
