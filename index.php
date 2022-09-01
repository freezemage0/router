<?php


require __DIR__ . '/vendor/autoload.php';


$router = new \Freezemage\Router\Router();
$router->get('/blog/{username}', function ($username) {
    echo sprintf('Welcome to %s\'s blog', $username);
});

$router->get('/blog/{username}/post/{id}', function ($username, $id) {
    echo sprintf('This is the post #%s from %s\'s blog', $id, $username);
});

$result = $router->process(new \Freezemage\Router\ServerRequest('GET', '/blog/freezemage0/post/1', '', []));
$result->getRoute()->execute();