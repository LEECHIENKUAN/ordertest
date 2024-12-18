<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * 測試新增訂檔成功
     *
     * @return void
     */
    public function testCreateOrderSuccess()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000002',
            'name' => 'Melody Holiday Inn',
            'address' => [
               'city' => 'taipei-city',
               'district' => 'da-an-district',
               'street' => 'fuxing-south-road',
            ],
            'price' => 2050,
            'currency' => 'TWD',
        ]);

        var_dump($response->json());
        $response->assertStatus(200);
    }

   /**
    * 測試取得訂單
    *
    * @return void
    */
    public function testGetOrderSuccess()
    {
        // ...
        $response = $this->get('/api/orders/A0000001');
        var_dump($response->json());
        $response->assertStatus(200);

    }

    public function testGetOrderNotFound()
    {
        $response = $this->get('/api/orders/111');
        $response->assertStatus(404);
    }
}
