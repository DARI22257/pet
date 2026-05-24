<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with(['category', 'primaryPhoto'])->paginate(12);
        return view('pets.index', compact('pets'));
    }

    public function show($slug)
    {
        $pet = Pet::where('slug', $slug)->with(['category', 'photos'])->firstOrFail();
        return view('pets.show', compact('pet'));
    }
}