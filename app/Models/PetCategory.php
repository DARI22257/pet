<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class PetCategory extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'slug', 'description'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'species_id');
    }
}
