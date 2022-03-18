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

namespace Nasumilu\StudentApp\Database;

use Nasumilu\StudentApp\Exception\InternalServerException;
use ReflectionClass;
use ReflectionException;

/**
 * Singleton which represents a database for this application.
 */
final class StudentDatabase
{

    /**
     * SHALL be the only instance of this call in the application
     * because it (typically) contains a database connection.
     * @var StudentDatabase|null
     */
    private static ?StudentDatabase $instance = null;

    /**
     * The application model repositories instances.
     *
     * Lazy loaded as needed
     * @var ModelRepository[]
     */
    private array $repository = [];

    /**
     * Singleton so private constructor
     */
    private function __construct()
    {
    }

    /**
     * Static factory to obtain an instance of the StudentDatabase
     *
     * @return StudentDatabase
     */
    public static function instance(): StudentDatabase
    {
        if(null === self::$instance) {
            self::$instance = new StudentDatabase();
        }
        return self::$instance;
    }

    /**
     * Gets a repository for a particular class or object.
     *
     * @throws ReflectionException if the ModelRepository can not be instantiated
     */
    public function getRepositoryFor(string|object $class): ModelRepository
    {
        if(is_object($class)) {
            $class = get_class($class);
        }
        if(!isset($this->repository[$class])) {
            $reflection = new ReflectionClass($class);
            if(null === $repositoryAttr = ($reflection->getAttributes(Repository::class)[0] ?? null)) {
                throw new InternalServerException();
            }
            $this->repository[$class] = $repositoryAttr->newInstance()->repositoryInstance();
        }
        return $this->repository[$class];
    }

}