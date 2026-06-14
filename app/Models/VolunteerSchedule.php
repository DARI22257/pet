<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class VolunteerSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'volunteer_id',
        'pet_id',
        'schedule_date',
        'start_time',
        'end_time',
        'activity_type',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'schedule_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'activity_type_label',
        'activity_color',
        'time_range',
        'duration',
        'is_upcoming',
        'is_today'
    ];


    /**
     * Get the volunteer (user) for this schedule.
     */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    /**
     * Get the pet associated with this schedule (if any).
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }


    /**
     * Get human-readable activity type label.
     */
    public function getActivityTypeLabelAttribute(): string
    {
        return [
            'walking' => '🚶 Выгул',
            'feeding' => '🍖 Кормление',
            'cleaning' => '🧹 Уборка',
            'grooming' => '✂️ Груминг',
            'other' => '📋 Другое',
        ][$this->activity_type] ?? '📋 ' . ucfirst($this->activity_type);
    }

    /**
     * Get Bootstrap color class for activity type.
     */
    public function getActivityColorAttribute(): string
    {
        return [
            'walking' => 'primary',
            'feeding' => 'success',
            'cleaning' => 'warning',
            'grooming' => 'info',
            'other' => 'secondary',
        ][$this->activity_type] ?? 'secondary';
    }

    /**
     * Get formatted time range (start — end).
     */
    public function getTimeRangeAttribute(): string
    {
        if (!$this->start_time || !$this->end_time) {
            return '—';
        }

        $start = Carbon::parse($this->start_time)->format('H:i');
        $end = Carbon::parse($this->end_time)->format('H:i');
        
        return $start . ' — ' . $end;
    }

    /**
     * Get duration of the schedule in hours and minutes.
     */
    public function getDurationAttribute(): string
    {
        if (!$this->start_time || !$this->end_time) {
            return '—';
        }

        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        
        $hours = $start->diffInHours($end);
        $minutes = $start->diffInMinutes($end) % 60;
        
        if ($hours === 0) {
            return $minutes . ' мин';
        }
        
        if ($minutes === 0) {
            return $hours . ' ч';
        }
        
        return $hours . ' ч ' . $minutes . ' мин';
    }

    /**
     * Check if the schedule is upcoming (future date or today with future end time).
     */
    public function getIsUpcomingAttribute(): bool
    {
        $scheduleDate = Carbon::parse($this->schedule_date);
        
        if ($scheduleDate->isFuture()) {
            return true;
        }
        
        if ($scheduleDate->isToday()) {
            return Carbon::parse($this->end_time)->isFuture();
        }
        
        return false;
    }

    /**
     * Check if the schedule is for today.
     */
    public function getIsTodayAttribute(): bool
    {
        return Carbon::parse($this->schedule_date)->isToday();
    }

    /**
     * Get formatted date for display (d.m.Y).
     */
    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->schedule_date)->format('d.m.Y');
    }

    /**
     * Get full date with day name.
     */
    public function getFullDateAttribute(): string
    {
        $days = [
            'Monday' => 'Понедельник',
            'Tuesday' => 'Вторник',
            'Wednesday' => 'Среда',
            'Thursday' => 'Четверг',
            'Friday' => 'Пятница',
            'Saturday' => 'Суббота',
            'Sunday' => 'Воскресенье',
        ];
        
        $date = Carbon::parse($this->schedule_date);
        $dayName = $days[$date->format('l')] ?? $date->format('l');
        
        return $dayName . ', ' . $date->format('d.m.Y');
    }


    /**
     * Scope a query to only include upcoming schedules.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('schedule_date', '>=', Carbon::today());
    }

    /**
     * Scope a query to only include past schedules.
     */
    public function scopePast($query)
    {
        return $query->where('schedule_date', '<', Carbon::today());
    }

    /**
     * Scope a query to only include schedules for today.
     */
    public function scopeToday($query)
    {
        return $query->where('schedule_date', Carbon::today());
    }

    /**
     * Scope a query to only include schedules for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('schedule_date', Carbon::parse($date)->toDateString());
    }

    /**
     * Scope a query to only include schedules for a specific volunteer.
     */
    public function scopeForVolunteer($query, $volunteerId)
    {
        return $query->where('volunteer_id', $volunteerId);
    }

    /**
     * Scope a query to only include schedules for a specific activity type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('activity_type', $type);
    }


    /**
     * Check if the schedule is associated with a pet.
     */
    public function hasPet(): bool
    {
        return !is_null($this->pet_id);
    }

    /**
     * Check if the schedule is valid (start_time < end_time).
     */
    public function isValidTimeRange(): bool
    {
        if (!$this->start_time || !$this->end_time) {
            return false;
        }
        
        return Carbon::parse($this->start_time)->lt(Carbon::parse($this->end_time));
    }

    /**
     * Get the status (upcoming, today, past).
     */
    public function getStatusAttribute(): string
    {
        $date = Carbon::parse($this->schedule_date);
        
        if ($date->isToday()) {
            return 'today';
        }
        
        if ($date->isFuture()) {
            return 'upcoming';
        }
        
        return 'past';
    }

    /**
     * Get status label in Russian.
     */
    public function getStatusLabelAttribute(): string
    {
        return [
            'today' => 'Сегодня',
            'upcoming' => 'Предстоит',
            'past' => 'Прошедшая',
        ][$this->status] ?? $this->status;
    }

    /**
     * Get status color for Bootstrap badge.
     */
    public function getStatusColorAttribute(): string
    {
        return [
            'today' => 'warning',
            'upcoming' => 'success',
            'past' => 'secondary',
        ][$this->status] ?? 'secondary';
    }


    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        // Add any model event listeners here
        static::creating(function ($schedule) {
            // Auto-set volunteer_id if not set
            if (!$schedule->volunteer_id && auth()->check()) {
                $schedule->volunteer_id = auth()->id();
            }
        });
        
        static::saving(function ($schedule) {
            // Ensure time range is valid
            if (!$schedule->isValidTimeRange()) {
                throw new \Exception('Время начала должно быть меньше времени окончания');
            }
        });
    }
}