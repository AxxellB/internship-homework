<?php

use PHPUnit\Framework\TestCase;

class apiTest extends TestCase
{
    private string $jwtToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0ZG9tYWluLmNvbSIsImlhdCI6MTcyNTQ1NzY0MCwiZXhwIjoxNzI1NDYxMjQwLCJkYXRhIjp7InVzZXJuYW1lIjoidGVzdDIifX0.xwydaO6Zckq1s3f5epjpfSwLuq3XWmnyWvK9P20W_Es";
    private $apiUrl = 'http://0.0.0.0:80';
    private $postRequest = CURLOPT_POST;
    private $putRequest = CURLOPT_PUT;

    public function testPostRequestCreatesNewTeacher()
    {
        $teachersFilePath = __DIR__ . '/../teachers.json';
        $teachers = json_decode(file_get_contents($teachersFilePath), true);

        $postData = [
            "firstName" => "testFirst",
            "lastName" => "testLast",
            "username" => "testUsername",
            "password" => "testPassword"
        ];
        $teacherCounterBefore = count($teachers);
        $response = $this->makeRequest($this->postRequest, $postData);
        $teachers = json_decode(file_get_contents($teachersFilePath), true);
        $teacherCounterAfter = count($teachers);

        $this->assertEquals(200, $response['http_code']);
        $this->assertEquals($teacherCounterBefore + 1, $teacherCounterAfter);
    }

    private function makeRequest($requestType, $postData, $apiUrl = 'http://0.0.0.0:80/')
    {
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->jwtToken,
        ]);
        curl_setopt($ch, $requestType, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'http_code' => $httpCode,
            'data' => json_decode($response, true)
        ];
    }

    public function testPostRequestWithMissingParamsReturnsError()
    {
        $teachersFilePath = __DIR__ . '/../teachers.json';

        $postData = [
            "firstName" => "test",
            "lastName" => null,
            "username" => null,
            "password" => null
        ];
        $response = $this->makeRequest($this->postRequest, $postData);

        $this->assertEquals(400, $response['http_code']);
        $this->assertArrayHasKey("message", $response['data']);
        $this->assertEquals("Please fill all required fields!", $response['data']['message']);
    }

    public function testPutRequestFailsWhenIdIsInvalid()
    {
        $teachersFilePath = __DIR__ . '/../teachers.json';
        $id = 456;
        $putUlr = trim($this->apiUrl . "?id=$id");
        $postData = [
            "firstName" => "testPut",
            "lastName" => "testPut2",
            "username" => "testUsername",
            "password" => "testPassword"
        ];

        $response = $this->makePutRequest($putUlr, $postData);

        $this->assertEquals(400, $response['http_code']);
        $this->assertArrayHasKey("message", $response['data']);
        $this->assertEquals("Teacher not found", $response['data']['message']);
    }

    function makePutRequest($url, array $data, array $headers = []): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $defaultHeaders = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data)),
            'Authorization: Bearer ' . $this->jwtToken,
        ];
        $allHeaders = array_merge($defaultHeaders, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['http_code' => $httpCode, 'error' => $error];
        }

        curl_close($ch);

        return ['http_code' => $httpCode, 'data' => json_decode($response, true)];
    }

    public function testPutRequestUpdatesATeacher()
    {
        $teachersFilePath = __DIR__ . '/../teachers.json';
        $id = 5;
        $putUlr = trim($this->apiUrl . "?id=$id");
        $postData = [
            "firstName" => "testPut",
            "lastName" => "testPut2",
            "username" => "testUsername",
            "password" => "testPassword"
        ];

        $response = $this->makePutRequest($putUlr, $postData);
        $teachers = json_decode(file_get_contents($teachersFilePath), true);
        $filtered_teachers = array_filter($teachers, function ($teacher) use ($id) {
            return $teacher['id'] == $id;
        });

        $current_teacher = reset($filtered_teachers);
        $key = array_search($current_teacher, $teachers);

        $this->assertEquals(200, $response['http_code']);
        $this->assertEquals($teachers[$key]['id'], $id);
        $this->assertEquals($teachers[$key]['firstName'], "testPut");
        $this->assertEquals($teachers[$key]['lastName'], "testPut2");
        $this->assertEquals($teachers[$key]['username'], "testUsername");
        $this->assertEquals($teachers[$key]['password'], "testPassword");

    }

    public function testGetRequestReturnsTeacherNotFound()
    {
        $id = 9999;
        $getUrl = $this->apiUrl . "?id=$id";

        $response = $this->makeGetRequest($getUrl);

        $this->assertEquals(404, $response['http_code']);
        $this->assertArrayHasKey('message', $response['data']);
        $this->assertEquals("Teacher not found", $response['data']['message']);
    }

    private function makeGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->jwtToken,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['http_code' => $httpCode, 'data' => json_decode($response, true)];
    }

    public function testPatchRequestUpdatesTeacher()
    {
        $id = 5;
        $patchUrl = $this->apiUrl . "?id=$id";
        $patchData = [
            "firstName" => "updatedFirstName",
        ];

        $response = $this->makePatchRequest($patchUrl, $patchData);
        $teachers = json_decode(file_get_contents(__DIR__ . '/../teachers.json'), true);
        $filtered_teacher = array_filter($teachers, function ($teacher) use ($id) {
            return $teacher['id'] == $id;
        });
        $updated_teacher = reset($filtered_teacher);

        $this->assertEquals(200, $response['http_code']);
        $this->assertEquals("updatedFirstName", $updated_teacher['firstName']);
    }

    private function makePatchRequest($url, array $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->jwtToken,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['http_code' => $httpCode, 'data' => json_decode($response, true)];
    }

    public function testDeleteRequestDeletesTeacher()
    {
        $id = 5;
        $deleteUrl = $this->apiUrl . "?id=$id";

        $response = $this->makeDeleteRequest($deleteUrl);
        $teachers = json_decode(file_get_contents(__DIR__ . '/../teachers.json'), true);
        $filtered_teacher = array_filter($teachers, function ($teacher) use ($id) {
            return $teacher['id'] == $id;
        });

        $this->assertEquals(200, $response['http_code']);
        $this->assertEquals("Teacher deleted successfully", $response['data']['message']);
        $this->assertEmpty($filtered_teacher);
    }


    private function makeDeleteRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->jwtToken,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['http_code' => $httpCode, 'data' => json_decode($response, true)];
    }

}