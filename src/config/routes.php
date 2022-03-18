<?php
/**
 * Application route configurations
 *
 * - methods : optional array or string values indicating the allowed http method. Default: GET
 * - path : required string indicating the route's path
 * - controller : A callable handler for the path
 *
 * @see https://www.php.net/manual/en/language.types.callable.php Callbacks / Callables
 * @see https://www.php.net/manual/en/functions.first_class_callable_syntax.php First class callback syntax
 */

use Nasumilu\StudentApp\Controller\StudentsController;
use Swoole\Http\Request;

return [
    [
        //'methods' => 'GET',
        'path' => '/students',
        'controller' => StudentsController::list(...)
    ],
    [
        //'methods' => 'GET',
        'path' => '/student-{id:\d+}',
        'controller' => StudentsController::retrieve(...)
    ],
    [
        'path' => '/student-{id:\d+}/grades',
        'controller' => fn(Request $request, array $args): array => StudentsController::retrieve($request, $args)->getGrades()
    ],
    [
        'path' => '/student-{id:\d+}/grades/stats',
        'controller' => StudentsController::stats(...)
    ],
    [
        //'methods' => 'GET',
        'path' => '/student-{id:\d+}/grades/average',
        // callable which just returns the 'average' offset from StudentController::stats method
        'controller' => fn(Request $request, array $args): float => StudentsController::stats($request, $args)['average']
    ],
    [
        'path' => '/student-{id:\d+}/grades/maximum',
        // callable which just returns the 'maximum' offset from StudentController::stats method
        'controller' => fn(Request $request, array $args): float => StudentsController::stats($request, $args)['maximum']
    ],
    [
        'path' => '/student-{id:\d+}/grades/minimum',
        // callable which just returns the 'minimum' offset from StudentController::stats method
        'controller' => fn(Request $request, array $args): float => StudentsController::stats($request, $args)['minimum']
    ],
    [
        'path' => '/student-{id:\d+}/grades/count',
        // callable which just returns the 'count' offset from StudentController::stats method
        'controller' => fn(Request $request, array $args): int => StudentsController::stats($request, $args)['count']
    ],
    [
        'path' => '/student-{id:\d+}/grades/sum',
        // callable which just returns the 'sum' offset from StudentController::stats method
        'controller' => fn(Request $request, array $args): float => StudentsController::stats($request, $args)['sum']
    ],
];
