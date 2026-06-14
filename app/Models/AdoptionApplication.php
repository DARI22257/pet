<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    protected $fillable = [
        'pet_id', 'applicant_id', 'full_name', 'phone', 'email',
        'address', 'experience', 'purpose', 'living_conditions',
        'status', 'rejection_reason', 'volunteer_notes'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function getStatusLabelAttribute()
    {
        return [
            'new' => 'Новая заявка',
            'under_review' => 'На рассмотрении',
            'approved' => 'Одобрена',
            'rejected' => 'Отклонена',
            'completed' => 'Завершена',
        ][$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return [
            'new' => 'info',
            'under_review' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'completed' => 'secondary',
        ][$this->status] ?? 'secondary';
    }

public function getStatusLabelAttribute()
{
    return [
        'new' => 'Новая заявка',
        'under_review' => 'На рассмотрении',
        'approved' => 'Одобрена',
        'rejected' => 'Отклонена',
        'completed' => 'Завершена',
    ][$this->status] ?? $this->status;
}

public function getStatusColorAttribute()
{
    return [
        'new' => 'info',
        'under_review' => 'warning',
        'approved' => 'success',
        'rejected' => 'danger',
        'completed' => 'secondary',
    ][$this->status] ?? 'secondary';
}
}
