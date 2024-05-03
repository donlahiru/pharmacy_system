<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testCustomerCanAddThroughApi()
    {
        $this->seed();

        $this->actingAsLoginUser();

        $response = $this->json('POST', '/api/customer/create', $this->data());

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Customer created successfully."]);
    }

    private function actingAsLoginUser()
    {
        $user = User::factory()->create();
        $user->assignRole('owner');
        Sanctum::actingAs($user);
    }

    private function data()
    {
        return [
            'first_name' => 'test name',
            'last_name' => 'last name',
            'street_address' => 'test street',
            'postal_code' => '12345',
            'city' => 'test city',
            'status' => 'active',
            'phone_no' => '0712345678'
        ];
    }

    public function testFirstNameIsRequired()
    {
        $this->seed();

        $this->actingAsLoginUser();

        $response = $this->json('POST', '/api/customer/create',
            array_merge($this->data(), ['first_name' => '']));

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => "Validation failed"]);
    }

    public function testFirstNameMax100Characters()
    {
        $this->seed();

        $this->actingAsLoginUser();

        $response = $this->json('POST', '/api/customer/create',
            array_merge($this->data(), ['first_name' => str_repeat('a', 101)]));

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => "Validation failed"]);
    }

    public function testPhoneNumberIsNumeric()
    {
        $this->seed();

        $this->actingAsLoginUser();

        $response = $this->json('POST', '/api/customer/create',
            array_merge($this->data(), ['phone_no' => 'aaaaaa']));

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => "Validation failed"]);
    }

    public function testPhoneNumberMax10Digits()
    {
        $this->seed();

        $this->actingAsLoginUser();

        $response = $this->json('POST', '/api/customer/create',
            array_merge($this->data(), ['phone_no' => '12345678911']));

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => "Validation failed"]);
    }


}
