<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request, Pet $pet)
    {
        // Проверка доступности питомца
        if ($pet->status !== 'available') {
            return back()->with('error', 'Этот питомец уже недоступен для усыновления');
        }
        
        // Проверка на существующую заявку (ЭТО ДЛЯ ВЕТКИ VALIDATION)
        $existingApplication = AdoptionApplication::where('pet_id', $pet->id)
            ->where('applicant_id', auth()->id())
            ->whereIn('status', ['new', 'under_review', 'approved'])
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'Вы уже подавали заявку на этого питомца. Текущий статус: ' . $existingApplication->statusLabel);
        }
        
        // Валидация формы
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'experience' => 'required|string',
            'purpose' => 'required|string',
            'living_conditions' => 'required|string',
        ]);
        
        // Создание заявки
        $application = AdoptionApplication::create([
            'pet_id' => $pet->id,
            'applicant_id' => auth()->id(),
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'experience' => $validated['experience'],
            'purpose' => $validated['purpose'],
            'living_conditions' => $validated['living_conditions'],
            'status' => 'new',
        ]);
        
        return redirect()->route('applications.my')
            ->with('success', 'Заявка на усыновление успешно отправлена!');
    }
    
    public function myApplications()
    {
        $applications = AdoptionApplication::with('pet')
            ->where('applicant_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('applications.my', compact('applications'));
    }
    
    public function show(AdoptionApplication $application)
    {
        // Проверка прав: только владелец или волонтёр/админ
        if ($application->applicant_id !== auth()->id() && !in_array(auth()->user()->role, ['admin', 'volunteer'])) {
            abort(403);
        }
        
        return view('applications.show', compact('application'));
    }
}