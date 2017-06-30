<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('{controller}/{action}');

// Routes for Projects
$router->add('post/show/{id:\+?\d+}', ['controller' => 'Post', 'action' => 'show']);
$router->add('post/edit/{id:\+?\d+}', ['controller' => 'Post', 'action' => 'edit']);
$router->add('post/delete/{id:\+?\d+}', ['controller' => 'Post', 'action' => 'delete']);
$router->add('post/remove/{id:\+?\d+}', ['controller' => 'Post', 'action' => 'remove']);

// Customer Routes
$router->add('customers/show/{id:\+?\d+}', ['controller' => 'Customers', 'action' => 'show']);
$router->add('customers/edit/{id:\+?\d+}', ['controller' => 'Customers', 'action' => 'edit']);
$router->add('customers/delete/{id:\+?\d+}', ['controller' => 'Customers', 'action' => 'delete']);
$router->add('customers/remove/{id:\+?\d+}', ['controller' => 'Customers', 'action' => 'remove']);

// Task Routes
$router->add('tasks/show/{id:\+?\d+}', ['controller' => 'Tasks', 'action' => 'show']);
$router->add('tasks/edit/{id:\+?\d+}', ['controller' => 'Tasks', 'action' => 'edit']);
$router->add('tasks/delete/{id:\+?\d+}', ['controller' => 'Tasks', 'action' => 'delete']);
$router->add('tasks/remove/{id:\+?\d+}', ['controller' => 'Tasks', 'action' => 'remove']);

$router->dispatch($_SERVER['QUERY_STRING']);
