<?php

namespace App\Services;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetService
{
    public function addPet(Request $request) {
        $response = Http::post('https://petstore.swagger.io/v2/pet/', $request->json());

        if ($response->successful()) {
            return ['status' => true, 'data' => $response->json()];
        } else {
            $message = $response->status() . '. ' . $response->reason();
            return ['status' => false, 'message' => $message];
        }
    }

    public function getPet(int $id) {
        $response = Http::get('https://petstore.swagger.io/v2/pet/' . $id);
        $data = $response->json();

        if ($response->successful()) {
            return ['status' => true, 'data' => $data];
        } else {
            $message = $response->status() . '. ' . $response->reason();
            return ['status' => false, 'message' => $message];
        }
    }

    public function updatePet(Request $request, int $id) {
        $body = $request->json();
        $body->id = $id;

        $response = Http::put('https://petstore.swagger.io/v2/pet', $body);

        if ($response->successful()) {
            return ['status' => true];
        } else {
            $message = $response->status() . '. ' . $response->reason();
            return ['status' => false, 'message' => $message];
        }
    }

    public function deletePet(int $id) {
        try {
            $response = Http::withHeaders(['api_key' => config('swagger.api_key')])->delete('https://petstore.swagger.io/v2/pet/' . $id);
        } catch (ConnectionException $e) {
            return redirect()->route('home')->with('error', $e->getCode() . ' ' . $e->getMessage());
        }

        if ($response->successful()) {
            return ['status' => true];
        } else {
            $message = $response->status() . '. ' . $response->reason();
            return ['status' => false, 'message' => $message];
        }
    }
}
