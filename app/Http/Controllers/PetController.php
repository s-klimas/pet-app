<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function addPetForm() {
        return view('addPetForm');
    }

    public function addPet(Request $request, PetService $petService) {
        $response = $petService->addPet($request);

        if ($response['status']) {
            return redirect()->route('home')->with('success', 'Pet successfully added with id ' . $response['data']['id']);
        } else {
            return redirect()->route('home')->with('error', $response['message']);
        }
    }

    public function getPet(int $id, PetService $petService) {
        $response = $petService->getPet($id);

        if ($response['status']) {
            return view('pet', ['data' => $response['data']]);
        } else {
            return redirect()->route('home')->with('error', $response['message']);
        }
    }

    public function updatePet(Request $request, int $id, PetService $petService) {
        $response = $petService->updatePet($request, $id);

        if ($response['status']) {
            return redirect()->route('home')->with('success', 'Pet successfully updated.');
        } else {
            return redirect()->route('home')->with('error', $response['message']);
        }
    }

    public function deletePet(int $id, PetService $petService) {
        $response = $petService->deletePet($id);

        if ($response['status']) {
            return redirect()->route('home')->with('success', 'Pet deleted successfully!');
        } else {
            return redirect()->route('home')->with('error', $response['message']);
        }
    }
}
