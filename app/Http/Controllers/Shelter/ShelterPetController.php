<?php

namespace App\Http\Controllers\Shelter;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\PetCategory;
use Illuminate\Http\Request;

class ShelterPetController extends Controller
{
    public function index()
    {
        $pets = Pet::with(['category', 'primaryPhoto'])->paginate(10);
        return view('shelter.pets.index', compact('pets'));
    }

    public function create()
    {
        $categories = PetCategory::all();
        return view('shelter.pets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species_id' => 'required|exists:pet_categories,id',
            'breed' => 'nullable|string|max:255',
            'age_estimate' => 'required|string|max:50',
            'gender' => 'required|in:male,female',
            'description' => 'required|string',
            'status' => 'required|in:available,treatment,adopted,reserved',
        ]);

        $pet = Pet::create($validated);

        return redirect()->route('shelter.pets.index')
            ->with('success', 'Питомец добавлен');
    }

    public function edit(Pet $pet)
    {
        $categories = PetCategory::all();
        return view('shelter.pets.edit', compact('pet', 'categories'));
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species_id' => 'required|exists:pet_categories,id',
            'breed' => 'nullable|string|max:255',
            'age_estimate' => 'required|string|max:50',
            'gender' => 'required|in:male,female',
            'description' => 'required|string',
            'status' => 'required|in:available,treatment,adopted,reserved',
        ]);

        $pet->update($validated);

        return redirect()->route('shelter.pets.index')
            ->with('success', 'Питомец обновлён');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();
        return redirect()->route('shelter.pets.index')
            ->with('success', 'Питомец удалён');
    }
}