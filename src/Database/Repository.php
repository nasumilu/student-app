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

use Attribute;
use RuntimeException;
use ReflectionClass;
use ReflectionException;

/**
 * The Repository attribute is used to indicate a model's ModelRepository class.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Repository
{
    public function __construct(private string $class)
    {
    }

    /**
     * Gets an instance of the ModelRepository class from a model object's Repository attribute
     *
     * @throws ReflectionException
     */
    public function repositoryInstance(): ModelRepository
    {
        $reflection = new ReflectionClass($this->class);
        if(!$reflection->isSubclassOf(ModelRepository::class)) {
            throw new RuntimeException("Expected an instance of " . ModelRepostory::class ." found {$this->class}!");
        }
        return $reflection->newInstance();
    }
}