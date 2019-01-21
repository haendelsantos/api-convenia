<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp\Client;
use Faker\Factory as Faker;

class FornecedoresTest extends TestCase
{
    const ROUTE_API = 'http://localhost:8000/api/v1/fornecedores/';
    const ROUTE_API_TOTAL_MENSALIDADE = 'http://localhost:8000/api/v1/total-mensalidade/';
      /**
     * Test restful routes
     *
     * @return void
     */
    public function testRestful()
    {
        $fornecedorId = $this->canCreate();
        $this->canList();
        $this->canListOne($fornecedorId);
        $this->canUpdate($fornecedorId);
        $this->canDelete($fornecedorId);
        $this->assertTrue(true);
    }
    /**
     * Get total of mensalidade
     *
     * Route /total-mensalidade GET
     *
     * @return void
     */
    public function testTotalMensalidade()
    {
        $res = (new Client())->request('GET', self::ROUTE_API_TOTAL_MENSALIDADE, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ]
        ]);
        $totalMensalidade = json_decode((string) $res->getBody());
        $this->assertGreaterThan(0,$totalMensalidade->total);
    }
    /**
     * ROUTE /fornecedores POST
     *
     * @return boolean
     */
    private function canCreate()
    {
        $faker = Faker::create();
        $res = (new Client())->request('POST', self::ROUTE_API, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ],
            'form_params' => [
                'name' => $faker->firstName,
                'email' => $faker->email,
                'mensalidade' => 100.00,
            ]
        ]);
        $fornecedor = json_decode((string) $res->getBody());
        return $fornecedor->id;
    }
    /**
     * ROUTE /fornecedores GET
     *
     * @return boolean
     */
    private function canList()
    {
        $res = (new Client())->request('GET', self::ROUTE_API, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ]
        ]);
        $fornecedores = json_decode((string) $res->getBody());

        return $this->assertEquals($res->getStatusCode(), 200);
    }
    /**
     * ROUTE /fornecedores/{id} SHOW
     *
     * @param int $fornecedorId
     * @return boolean
     */
    private function canListOne($fornecedorId)
    {
        return $this->getFornecedor($fornecedorId);
    }
    /**
     * ROUTE /fornecedores PUT
     *
     * @param int $fornecedorId
     * @return boolean
     */
    private function canUpdate($fornecedorId)
    {
        $fornecedorBefore = $this->getFornecedor($fornecedorId);
        $faker = Faker::create();
        $res = (new Client())->request('PUT', self::ROUTE_API . $fornecedorId, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ],
            'form_params' => [
                'email' => $faker->email,
            ]
        ]);
        $fornecedor = $this->getFornecedor($fornecedorId);
        $this->assertNotEquals($fornecedorBefore->email,$fornecedor->email);
    }
    /**
     * ROUTE /fornecedores/{id} DELETE
     *
     * @param int $fornecedorId
     * @return boolean
     */
    private function canDelete($fornecedorId)
    {
        $fornecedor = $this->getFornecedor($fornecedorId);
        $res = (new Client())->request('DELETE', self::ROUTE_API . $fornecedorId, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ]
        ]);
        return $this->assertEquals($res->getStatusCode(), 200);
    }

    /**
     * Get Fornecedor
     *
     * @param int $fornecedorId
     * @return void
     */
    private function getFornecedor($fornecedorId)
    {
        $res = (new Client())->request('GET', self::ROUTE_API . $fornecedorId, [
            'headers' => [
                'Authorization' => env("PERSONAL_AUTH_KEY"),
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertEquals($res->getStatusCode(), 200);

        return json_decode((string) $res->getBody());
    }
}
