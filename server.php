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

require_once __DIR__.'/vendor/autoload.php';

use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Nasumilu\StudentApp\Router;
use Nasumilu\StudentApp\Exception\HttpException;
use Nasumilu\StudentApp\Exception\InternalServerException;

ini_set('xdebug.remote_enable', 0);
ini_set('xdebug.remote_autostart', 0);
ini_set('xdebug.default_enable', 0);

// should be configurable
$server = new Swoole\HTTP\Server('127.0.0.1', 9501);

$server->on("start", function (Server $server) {
    echo "Student App http server is started at http://127.0.0.1:9501\n";
});

$server->on("request", function (Request $request, Response $response) {
    $response->header('Content-Type', 'application/json');
    try {
        $router = new Router();
        $data = array_merge(
            ['status' => 200],
            $router->dispatch($request, $response)
        );

    } catch(Exception|Error $ex) {
        // pokemon catch turn anything not an HttpException into an InternalServerException
        if(!$ex instanceof HttpException) {
            $ex = new InternalServerException(previous: $ex);
        }
        $code = $ex->getCode();
        $response->status($code);
        $data = [
            'status' => $code,
            'message' => $ex->getMessage()
        ];
    } finally {
        $response->write(json_encode($data, true));
        $response->end();
    }
});

$server->start();

