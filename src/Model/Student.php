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

namespace Nasumilu\StudentApp\Model;

use InvalidArgumentException;
use JsonSerializable;
use Nasumilu\StudentApp\Database\Repository;
use Nasumilu\StudentApp\Database\StaticStudentRepository;
use function array_values;

/**
 * The data model for this application.
 */
#[Repository(class: StaticStudentRepository::class)]
class Student implements  JsonSerializable
{

    /**
     * @param int|null $id The student's unique id
     * @param string|null $name The name of the student
     * @param array $grades An array of assigned grades
     */
    public function __construct(private ?int $id = null, private ?string $name = null, private array $grades = []) { }

    /**
     * Gets the student's unique identifier
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Sets the student's unique identifier
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets the student's name
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the student's name
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets the student's grades
     * @return array
     */
    public function getGrades(): array
    {
        return $this->grades;
    }

    /**
     * Sets the student's grades
     * @param array $grades
     */
    public function setGrades(array $grades): void
    {
        $this->grades = $grades;
    }

    /**
     * Append a grade to the list of student's grades
     * @param float $grade
     * @param int|null $offset
     * @return $this
     */
    public function addGrade(float $grade, ?int $offset = null): self
    {
        if($grade < 0) {
            throw new InvalidArgumentException("Grade must be greater than zero, found $grade!");
        }
        $this->grades[$offset ?? coun($this->grades)] = $grade;
        return $this;
    }

    /**
     * Remove a grade from the list of student grades.
     * @param int $offset
     * @return float|null
     */
    public function removeGrade(int $offset): ?float
    {
        if(null !== $grade = ($this->grades[$offset] ?? null)) {
            unset($this->grades[$offset]);
            $this->grades = array_values($this->grades);
        }
        return $grade;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'grades' => $this->grades
        ];
    }
}