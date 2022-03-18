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

use Nasumilu\StudentApp\Exception\NotFoundException;

/**
 * A ModeRepository is the general means to retrieve a model's data. Where a model is
 * any instantiable object.
 */
interface ModelRepository
{

    /**
     * Finds and returns all instance of a model.
     *
     * @return array
     */
    public function findAll(): array;

    /**
     * Finds a model by its unique id
     * @param int $id
     * @return mixed
     * @throws NotFoundException
     */
    public function find(mixed $id): mixed;

}