<?php

use PHPUnit\Framework\TestCase;

class loginTest extends TestCase
{
    private $apiUrl = 'http://0.0.0.0:80/login.php';

    private function makePostRequest($postData)
    {
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'http_code' => $httpCode,
            'data' => json_decode($response, true)
        ];
    }
    
    public function testLoginSuccess()
    {
        $postData = [
            'username' => 'test1',
            'password' => 'test'
        ];

        $response = $this->makePostRequest($postData);

        $this->assertEquals(200, $response['http_code']);
        $this->assertArrayHasKey('jwt', $response['data']);
        $this->assertArrayHasKey('message', $response['data']);
        $this->assertEquals('Login successful', $response['data']['message']);
    }

    public function testLoginFailure()
    {
        $postData = [
            'username' => 'invalidUsername',
            'password' => 'invalidPassword'
        ];

        $response = $this->makePostRequest($postData);

        $this->assertEquals(401, $response['http_code']);
        $this->assertArrayHasKey('message', $response['data']);
        $this->assertEquals('Invalid username or password', $response['data']['message']);
    }

    public function testMissingCredentials()
    {
        $postData = [
            'username' => null,
            'password' => null
        ];

        $response = $this->makePostRequest($postData);

        $this->assertEquals(400, $response['http_code']);
        $this->assertArrayHasKey('message', $response['data']);
        $this->assertEquals('Missing username or password', $response['data']['message']);
    }
}
