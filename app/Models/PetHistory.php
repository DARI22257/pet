<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetHistory extends Model
{
    protected $fillable = [
        'pet_id',
        'history_date',
        'type',
        'description',
        'veterinarian',
        'created_by'
    ];

    protected $casts = [
        'history_date' => 'date',
    ];

    protected $appends = ['type_label', 'type_color', 'formatted_date'];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return [
            'vaccination' => '💉 Вакцинация',
            'treatment' => '💊 Лечение',
            'examination' => '🔍 Осмотр',
            'surgery' => '🏥 Операция',
            'other' => '📝 Другое',
        ][$this->type] ?? $this->type;
    }

    public function getTypeColorAttribute(): string
    {
        return [
            'vaccination' => 'success',
            'treatment' => 'warning',
            'examination' => 'info',
            'surgery' => 'danger',
            'other' => 'secondary',
        ][$this->type] ?? 'secondary';
    }

    public function getFormattedDateAttribute(): string
    {
        return \Carbon\Carbon::parse($this->history_date)->format('d.m.Y');
    }
}