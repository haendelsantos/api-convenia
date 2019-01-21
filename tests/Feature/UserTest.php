<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp\Client;
use Faker\Factory as Faker;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{
    const ROUTE_API = 'http://localhost:8000/api/v1/user/';

    /**
     * Restful test Users routes
     *
     * @return void
     */
    public function testRestful()
    {
        $userId = $this->canCreateUser();
        $this->canListUsers();
        $this->canListOneUser($userId);
        $this->assertTrue(true);
    }
    /**
     * Route /users POST
     *
     * @return boolean
     */
    private function canCreateUser()
    {
        $faker = Faker::create();
        $res = (new Client())->request('POST', self::ROUTE_API, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ],
            'form_params' => [
                'name' => $faker->firstName,
                'phone' => $faker->randomNumber(9),
                'address' => $faker->address,
                'cep' => $faker->randomNumber(6),
                'cnpj' => $faker->randomNumber(4),
                'email' => $faker->email,
                'password' => '123456',
            ]
        ]);

        $user = json_decode((string) $res->getBody());
        $this->assertEquals($res->getStatusCode(), 200);
        $this->assertNotEquals(0,$user->id);
        return $user->id;
    }
    /**
     * Route /users GET
     *
     * @return boolean
     */
    private function canListUsers()
    {
        $res = (new Client())->request('GET', self::ROUTE_API, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ]
        ]);
        $users = json_decode((string) $res->getBody());

        $this->assertEquals($res->getStatusCode(), 200);
    }
    /**
     * Route /users/{id} GET
     *
     * @return boolean
     */
    private function canListOneUser($userId)
    {
        return $this->getUser($userId);
    }

    /**
     * Get User
     *
     * @param int $userId
     * @return void
     */
    private function getUser($userId)
    {
        $res = (new Client())->request('GET', self::ROUTE_API . $userId, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertEquals($res->getStatusCode(), 200);

        return json_decode((string) $res->getBody());
    }
}
