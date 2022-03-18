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
use Nasumilu\StudentApp\Model\Student;
use function number_format;
use function array_filter;
use function array_sum;
use function array_values;
use function count;
use function min;
use function max;

/**
 * Static ModelRepository for development. Should be replaced with a
 * repository backed by a database.
 *
 */
class StaticStudentRepository implements ModelRepository
{

    /**
     * Some static data (ideally the data would come from a database)
     *
     * @var array|Student[]
     */
    private static array $data;

    /**
     * Constructs the ModelRepository with some static data for testing.
     */
    public function __construct() {
        self::$data = [
            new Student(id: 1, name: 'Test Student One', grades: [100, 99.5, 95, 87.5, 96.2, 78.4]),
            new Student(id: 2, name: 'Test Student Two', grades: [87.2, 99, 85.6, 85.6, 94, 70]),
            new Student(3, 'Test Student Three')
        ];
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return self::$data;
    }

    /**
     * @inheritDoc
     */
    public function find(mixed $id): Student
    {
        $filter = array_values(array_filter(self::$data, fn (Student $row): bool => (int) $id === $row->getId()));
        if(!isset($filter[0])) {
            throw new NotFoundException();
        }
        return $filter[0];
    }

    /**
     * This obtains the status from the for a student by their unique identifier
     *
     * @param int $id
     * @return array
     */
    public function findGradeStatsFor(int $id): array
    {

        if(null === $student = $this->find($id)) {
            throw new NotFoundException();
        }
        $grades = $student->getGrades();
        $count = count($grades);
        $sum = array_sum($grades);
        return [
            'sum' => (float) number_format($sum, 1),
            'average' => $count === 0 ? 0.0 : (float) number_format($sum/$count, 1),
            'maximum' => $count === 0 ? 0 : max($grades),
            'minimum' => $count === 0 ? 0 : min($grades),
            'count' => $count
        ];
    }
}