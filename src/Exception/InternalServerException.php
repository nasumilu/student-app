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

namespace Nasumilu\StudentApp\Exception;

use Throwable;

/**
 * An HttpException with a 500 HTTP status code
 */
class InternalServerException extends HttpException
{

    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(code: HttpStatusCode::INTERNAL_ERROR, message: 'Internal Server Error!', previous: $previous);
    }

}