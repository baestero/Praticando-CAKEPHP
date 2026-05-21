<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;


return function (RouteBuilder $routes): void {
    // $routes->connect('/', ['controller' => 'Home', 'action' => 'index'], [
    //     '_name' => 'home.index'
    // ])->setMethods(['GET']);

    // $routes->connect('/about', ['controller' => 'About', 'action' => 'index'], [
    //     '_name' => 'about.index'
    // ])->setMethods(['GET', 'POST']);

    // $routes->connect('/product/{id}/name/{name}', ['controller' => 'Product', 'action' => 'show'], [
    //     '_name' => 'product.show',
    //     'pass' => ['id', 'name'],
    //     'id' => '[0-9]+',
    //     'name' => '[a-z]+'
    // ])->setMethods(['GET']);

    // $routes->get('/', ['controller' => 'Home', 'action' => 'index'], 'home.index');
    // $routes->get('/about', ['controller' => 'About', 'action' => 'index'], 'about.index');
    // $routes->get(
    //     '/product/{id}',
    //     ['controller' => 'Product', 'action' => 'show'],
    //     'product.show'
    // )->setPatterns(['id' => '[0-9]+']);


    //$routes->connect('/clube/*', ['controller' => 'Clube', 'action' => 'index']);


    $routes->scope('/', function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home', 'action' => 'index'], [
            '_name' => 'home.index'
        ])->setMethods(['GET']);

        $routes->connect('/about', ['controller' => 'About', 'action' => 'index'], [
            '_name' => 'about.index'
        ])->setMethods(['GET', 'POST']);

        $routes->connect('/product/{id}/name/{name}', ['controller' => 'Product', 'action' => 'show'], [
            '_name' => 'product.show',
            'pass' => ['id', 'name'],
            'id' => '[0-9]+',
            'name' => '[a-z]+'
        ])->setMethods(['GET']);
    });


    $routes->scope('/admin', function (RouteBuilder $routes) {
        $routes->connect(
            '/',
            ['controller' => 'Admin', 'action' => 'index'],
            ['_name' => 'admin.index']
        );
        $routes->connect(
            '/users',
            ['controller' => 'AdminUsers', 'action' => 'index'],
            ['_name' => 'adminusers.index']
        );
        $routes->connect(
            '/users/{id}',
            ['controller' => 'AdminUsers', 'action' => 'show'],
            [
                '_name' => 'adminusers.show',
                'pass' => ['id'],
                'id' => '[0-9]+'
            ]
        );
    });
};
