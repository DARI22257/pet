<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetCategory;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::with(['category', 'primaryPhoto']);
        
        // Фильтр по статусу (по умолчанию показываем доступных)
        if (!$request->filled('status') || $request->status === 'available') {
            $query->where('status', 'available');
        } elseif ($request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Фильтр по категории
        if ($request->filled('category')) {
            $query->where('species_id', $request->category);
        }
        
        // Фильтр по полу
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        
        // Поиск по кличке и породе
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%");
            });
        }
        
        // Сортировка
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('name');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
        }
        
        $pets = $query->paginate(12)->withQueryString();
        $categories = PetCategory::all();
        
        return view('pets.index', compact('pets', 'categories'));
    }
    
    public function show(Pet $pet)
    {
        $pet->load(['photos', 'category', 'histories' => function($q) {
            $q->latest('history_date');
        }]);
        
        return view('pets.show', compact('pet'));
    }
}