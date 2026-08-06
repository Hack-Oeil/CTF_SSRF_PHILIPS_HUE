<?php

return function (\FastRoute\RouteCollector $router) {
    // Page d'accueil

    $router->get('/spelights-secret-124873-private-light-on', 'App\Controller\LightController::index');
    $router->get('/', 'App\Controller\BlogController::index');
    $router->get('/index.php', 'App\Controller\BlogController::index');

    // Page de contact
    $router->get('/contact', 'App\Controller\ContactController::index');
    $router->post('/contact', 'App\Controller\ContactController::submit');
};
