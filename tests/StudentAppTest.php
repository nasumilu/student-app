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

namespace Nasumilu\StudentApp\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StudentAppTest extends TestCase
{

    private static ?HttpClientInterface $httpClient = null;

    public static function setUpBeforeClass(): void
    {
        self::$httpClient = HttpClient::createForBaseUri($_ENV['APP_URL']);
    }

    /**
     * @test
     * @testWith ["GET", "/students"]
     *           ["GET", "/student-1"]
     *           ["GET", "/student-1/grades"]
     *           ["GET", "/student-1/grades/stats"]
     *           ["GET", "/student-1/grades/average"]
     *           ["GET", "/student-1/grades/maximum"]
     *           ["GET", "/student-1/grades/minimum"]
     *           ["GET", "/student-1/grades/count"]
     *           ["GET", "/student-1/grades/sum"]
     * @param string $method the request's http method
     * @param string $path the request's endpoint
     * @return void
     * @throws TransportExceptionInterface
     */
    public function endpoints(string $method, string $path): void
    {
        $response = self::$httpClient->request($method, $path);
        // check that all the app endpoints work and content-type is application/json
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaders()['content-type'][0]);

        // check that the response is valid JSON
        $this->assertJson($response->getContent());

        // check that the response JSON contains the required 'status' and 'data' keys
        $content = $response->toArray();
        $this->assertIsArray($content);
        $this->assertArrayHasKey('status', $content);
        $this->assertArrayHasKey('data', $content);

    }


}