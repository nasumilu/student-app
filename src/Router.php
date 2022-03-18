<?php

/*
 * Copyright 2022 Michael Lucas <nasumilu@gmail.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Nasumilu\StudentApp;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Nasumilu\StudentApp\Exception\MethodNotAllowedException;
use Nasumilu\StudentApp\Exception\NotFoundException;
use Swoole\Http\Request;
use Swoole\Http\Response;

use function FastRoute\simpleDispatcher;

/**
 * Simple class to configure uri endpoints to callbacks.
 *
 * @see https://github.com/nikic/FastRoute nikic/FastRoute
 */
class Router
{

    /**
     * The dispatcher used to dispatch a uri to a php callback.
     *
     * @var Dispatcher
     */
    private Dispatcher $dispatcher;

    /**
     * Constructs a Router instance using the configuration file found in
     * [app_root]/config/routes.php.
     *
     */
    public function __construct()
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $router) {
            $routes = require __DIR__.'/config/routes.php';
            foreach($routes as $route) {
                $router->addRoute($route['methods'] ?? 'GET', $route['path'], $route['controller']);
            }
        });
    }

    /**
     * This app's response MUST return JSON. So all callbacks return are added to an array as offset 'data'.
     *
     * <strong>IMPORTANT</strong> All callback data SHALL be serializable values using PHP's native json_encode function.
     *
     * @param Request $request the request object
     * @param Response $response the response object
     * @return array the data from the route's callback
     */
    public function dispatch(Request $request, Response $response): array
    {
        [$code, $controller, $args] = $this->dispatcher->dispatch(
            $request->server['request_method'],
            $request->server['request_uri']
        );

        // PHP's 8 match statement
        // @see https://www.php.net/manual/en/control-structures.match.php
        $data = match($code) {
            Dispatcher::NOT_FOUND => throw new NotFoundException(),
            Dispatcher::METHOD_NOT_ALLOWED => throw new MethodNotAllowedException(),
            default => call_user_func($controller, $request, $args)
        };


        return [
            'data' => $data
        ];
    }

}