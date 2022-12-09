<?php

namespace Tests\Payment\Feature;

use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_return_view_when_call_checkoute()
    {
        $response = $this->get('/');
        $response->assertSee(config('order.order_id'));
        $response->assertSee(config('order.product_name'));
        $response->assertSee(config('order.product_description'));
        $response->assertSee(config('order.price'));
    }

    /**
     * @test
     */
    public function it_can_validate_create_payment()
    {
        $payload = [
            'card_number' => '123456',
            'gateway' => 'paystar'
        ];

        $this->post(route('payment.create'), $payload)
            ->assertStatus(302);

        $payload = [
            'card_number' => '1234567891234567',
            'gateway' => 'mellat'
        ];

        $this->post(route('payment.create'), $payload)
            ->assertStatus(302);
    }

    /**
     * @test
     */
    public function it_can_create_payment()
    {
        $payload = [
            'card_number' => '1234567891234567',
            'gateway' => 'paystar'
        ];

        $this->post(route('payment.create'), $payload)
            ->assertStatus(200);
    }
}
