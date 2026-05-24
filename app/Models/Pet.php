<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Pet extends Model
{
    use Sluggable;

    protected $fillable = [
        'name', 'slug', 'species_id', 'breed', 'age_estimate',
        'gender', 'description', 'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(PetCategory::class, 'species_id');
    }

    public function photos()
    {
        return $this->hasMany(PetPhoto::class);
    }

    public function primaryPhoto()
    {
        return $this->hasOne(PetPhoto::class)->where('is_primary', true);
    }

    public function adoptionApplications()
    {
        return $this->hasMany(AdoptionApplication::class);
    }

    public function histories()
    {
        return $this->hasMany(PetHistory::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'available' => 'Доступен',
            'treatment' => 'На лечении',
            'adopted' => 'Усыновлён',
            'reserved' => 'Зарезервирован',
        ][$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return [
            'available' => 'success',
            'treatment' => 'warning',
            'adopted' => 'primary',
            'reserved' => 'info',
        ][$this->status] ?? 'secondary';
    }
}
