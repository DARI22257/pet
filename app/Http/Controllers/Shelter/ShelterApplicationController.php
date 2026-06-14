<?php

namespace App\Http\Controllers\Shelter;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class ShelterApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-pets');
    }
    
    public function index()
    {
        $applications = AdoptionApplication::with(['pet', 'applicant'])
            ->latest()
            ->paginate(20);
            
        return view('shelter.applications.index', compact('applications'));
    }
    
    public function show(AdoptionApplication $application)
    {
        return view('shelter.applications.show', compact('application'));
    }
    
    public function startReview(AdoptionApplication $application)
    {
        if ($application->status !== 'new') {
            return back()->with('error', 'Эту заявку уже нельзя перевести в режим рассмотрения');
        }
        
        $application->update(['status' => 'under_review']);
        return back()->with('success', 'Заявка переведена в режим рассмотрения');
    }
    
    public function approve(AdoptionApplication $application)
    {
        if ($application->status !== 'under_review') {
            return back()->with('error', 'Эту заявку уже нельзя одобрить');
        }
        
        if ($application->pet->status === 'adopted') {
            return back()->with('error', 'Этот питомец уже усыновлён');
        }
        
        $application->update(['status' => 'approved']);
        $application->pet->update(['status' => 'adopted']);
        
        return back()->with('success', 'Заявка одобрена! Питомец помечен как усыновлённый');
    }
    
    public function reject(Request $request, AdoptionApplication $application)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500'
        ]);
        
        if (!in_array($application->status, ['new', 'under_review'])) {
            return back()->with('error', 'Эту заявку уже нельзя отклонить');
        }
        
        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);
        
        return back()->with('success', 'Заявка отклонена');
    }
    
    public function complete(AdoptionApplication $application)
    {
        if ($application->status !== 'approved') {
            return back()->with('error', 'Эту заявку уже нельзя завершить');
        }
        
        $application->update(['status' => 'completed']);
        return back()->with('success', 'Процедура усыновления завершена');
    }
}