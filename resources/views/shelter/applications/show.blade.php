@extends('layouts.app')

@section('title', 'Заявка #' . $application->id)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Заявка #{{ $application->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>🐾 Питомец</h5>
                            <p><strong>Кличка:</strong> {{ $application->pet->name }}</p>
                            <p><strong>Вид:</strong> {{ $application->pet->category->name ?? '-' }}</p>
                            <p><strong>Порода:</strong> {{ $application->pet->breed ?? '-' }}</p>
                            <p><strong>Возраст:</strong> {{ $application->pet->age_estimate }}</p>
                            <p><strong>Статус:</strong> 
                                <span class="badge bg-{{ $application->pet->statusColor }}">
                                    {{ $application->pet->statusLabel }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>👤 Заявитель</h5>
                            <p><strong>ФИО:</strong> {{ $application->full_name }}</p>
                            <p><strong>Телефон:</strong> {{ $application->phone }}</p>
                            <p><strong>Email:</strong> {{ $application->email }}</p>
                            <p><strong>Адрес:</strong> {{ $application->address }}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6>📝 Опыт содержания</h6>
                            <p>{{ $application->experience }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6>🎯 Цель усыновления</h6>
                            <p>{{ $application->purpose }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6>🏠 Условия содержания</h6>
                            <p>{{ $application->living_conditions }}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>📊 Статус заявки</h5>
                    <p><span class="badge bg-{{ $application->statusColor }} fs-6">{{ $application->statusLabel }}</span></p>
                    
                    @if($application->volunteer_notes)
                        <div class="alert alert-info mt-3">
                            <strong>📌 Заметки волонтёра:</strong><br>
                            {{ $application->volunteer_notes }}
                        </div>
                    @endif
                    
                    @if($application->rejection_reason)
                        <div class="alert alert-danger mt-3">
                            <strong>❌ Причина отклонения:</strong><br>
                            {{ $application->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Действия</h5>
                </div>
                <div class="card-body">
                    @if($application->status === 'new')
                        <form action="{{ route('shelter.applications.review', $application) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                Начать рассмотрение
                            </button>
                        </form>
                        
                        <form action="{{ route('shelter.applications.reject', $application) }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <textarea name="rejection_reason" class="form-control" placeholder="Причина отклонения..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                Отклонить заявку
                            </button>
                        </form>
                    @endif
                    
                    @if($application->status === 'under_review')
                        <form action="{{ route('shelter.applications.approve', $application) }}" method="POST" class="mb-2">
                            @csrf
                            <div class="mb-2">
                                <textarea name="volunteer_notes" class="form-control" placeholder="Заметки (необязательно)"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                Одобрить усыновление
                            </button>
                        </form>
                        
                        <form action="{{ route('shelter.applications.reject', $application) }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <textarea name="rejection_reason" class="form-control" placeholder="Причина отклонения..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                Отклонить заявку
                            </button>
                        </form>
                    @endif
                    
                    @if($application->status === 'approved')
                        <form action="{{ route('shelter.applications.complete', $application) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary w-100">
                                Завершить усыновление
                            </button>
                        </form>
                    @endif
                    
                    <hr>
                    <a href="{{ route('shelter.applications.index') }}" class="btn btn-outline-secondary w-100">
                        ← Назад к списку
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection