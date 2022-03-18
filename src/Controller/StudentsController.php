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

namespace Nasumilu\StudentApp\Controller;

use Nasumilu\StudentApp\Database\StudentDatabase;
use Nasumilu\StudentApp\Model\Student;
use ReflectionException;
use Swoole\Http\Request;

/**
 * Class contains the handler callback's for the application defined in [app_root]/config/routes.php file.
 */
class StudentsController
{

    /**
     * Gets the grading stats for a student by their unique identifier
     *
     * Path: /student-{id:\d+}/grades/stats
     *
     * @throws ReflectionException
     */
    public static function stats(Request $request, array $args): array
    {
        return StudentDatabase::instance()
                ->getRepositoryFor(Student::class)
                ->findGradeStatsFor($args['id']);
    }

    /**
     * Gets a Student by their unique identifier.
     *
     * Path: /student-{id\d+}
     *
     * @param Request $request The request this callback is handling
     * @param array $args Must have 'id' with the unique identifier for a Student
     * @return Student The Student with the unique identifier $args['id']
     * @throws ReflectionException
     */
    public static function retrieve(Request $request, array $args): Student
    {
        return StudentDatabase::instance()
                ->getRepositoryFor(Student::class)
                ->find($args['id']);
    }

    /**
     * Gets all Student objects
     *
     * Path: /students
     *
     * @param Request $request
     * @return array An array with all the Student objects
     * @throws ReflectionException
     */
    public static function list(Request $request): array
    {
        return StudentDatabase::instance()
                ->getRepositoryFor(Student::class)
                ->findAll();
    }

}