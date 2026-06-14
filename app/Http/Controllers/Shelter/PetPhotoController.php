<?php

namespace App\Http\Controllers\Shelter;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\PetPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetPhotoController extends Controller
{
    public function store(Request $request, Pet $pet)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->file('photo')->store('pets', 'public');
        
        $isPrimary = $pet->photos()->count() === 0;
        
        $pet->photos()->create([
            'photo_path' => $path,
            'is_primary' => $isPrimary
        ]);

        return back()->with('success', 'Фото добавлено');
    }

    public function destroy(Pet $pet, PetPhoto $photo)
    {
        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();
        return back()->with('success', 'Фото удалено');
    }
    
    public function setPrimary(Pet $pet, PetPhoto $photo)
    {
        $pet->photos()->update(['is_primary' => false]);
        $photo->update(['is_primary' => true]);
        return back()->with('success', 'Главное фото обновлено');
    }
}