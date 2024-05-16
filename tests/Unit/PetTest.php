<?php

namespace Tests\Unit;

use App\Services\PetService;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PetTest extends TestCase {
    public function test_add_pet_successful()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/' => Http::response(['id' => 123, 'name' => 'Fluffy'], 200)
        ]);
        $request = new Request([
            'id' => 123,
            'name' => 'Fluffy'
        ]);

        $service = new PetService();
        $result = $service->addPet($request);

        $this->assertTrue($result['status']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals(123, $result['data']['id']);
        $this->assertEquals('Fluffy', $result['data']['name']);
    }

    public function test_add_pet_unsuccessful()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/' => Http::response(null, 400, ['Reason' => 'Bad Request'])
        ]);
        $request = new Request([
            'id' => 123,
            'name' => 'Fluffy'
        ]);

        $service = new PetService();
        $result = $service->addPet($request);

        $this->assertFalse($result['status']);
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('400. Bad Request', $result['message']);
    }

    public function test_get_pet_successful() {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/123' => Http::response(['id' => 123, 'name' => 'Fluffy'], 200)
        ]);
        $service = new PetService();
        $result = $service->getPet(123);

        $this->assertTrue($result['status']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals(123, $result['data']['id']);
        $this->assertEquals('Fluffy', $result['data']['name']);
    }

    public function test_get_pet_unsuccessful() {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/123' => Http::response(null, 404, ['Reason' => 'Not Found'])
        ]);
        $service = new PetService();
        $result = $service->getPet(123);

        $this->assertFalse($result['status']);
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('404. Not Found', $result['message']);
    }

    public function test_update_pet_successful() {
        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response(null, 200)
        ]);
        $request = new Request([
            'name' => 'Fluffy',
            'status' => 'available'
        ]);
        $service = new PetService();
        $result = $service->updatePet($request, 123);

        $this->assertTrue($result['status']);
        $this->assertArrayNotHasKey('message', $result);
    }

    public function test_update_pet_unsuccessful() {
        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response(null, 400, ['Reason' => 'Bad Request'])
        ]);
        $request = new Request([
            'name' => 'Fluffy',
            'status' => 'available'
        ]);

        $service = new PetService();
        $result = $service->updatePet($request, 123);

        $this->assertFalse($result['status']);
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('400. Bad Request', $result['message']);
    }

    public function test_delete_pet_successful() {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/123' => Http::response(null, 200)
        ]);
        $service = new PetService();
        $result = $service->deletePet(123);

        $this->assertTrue($result['status']);
        $this->assertArrayNotHasKey('message', $result);
    }

    public function test_delete_pet_unsuccessful() {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/123' => Http::response(null, 404, ['Reason' => 'Not Found'])
        ]);
        $service = new PetService();
        $result = $service->deletePet(123);

        $this->assertFalse($result['status']);
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('404. Not Found', $result['message']);
    }

    public function test_delete_pet_connection_exception() {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/123' => function () {
                throw new ConnectException('Connection refused', new \GuzzleHttp\Psr7\Request('DELETE', 'test'));
            },
        ]);
        Route::get('/home', function () {
            return 'Home';
        })->name('home');
        $service = new PetService();
        $response = $service->deletePet(123);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('home'), $response->getTargetUrl());
        $this->get(route('home'))->assertSessionHas('error', '0 Connection refused');
    }
}
