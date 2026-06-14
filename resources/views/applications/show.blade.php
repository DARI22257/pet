@extends('layouts.app')

@section('title', 'Заявка #' . $application->id)

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Заявка на усыновление #{{ $application->id }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>🐾 Информация о питомце</h5>
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
                    <h5>👤 Данные заявителя</h5>
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
            
            <div class="row">
                <div class="col-md-6">
                    <h5>📊 Статус заявки</h5>
                    <p>
                        <span class="badge bg-{{ $application->statusColor }} fs-6">
                            {{ $application->statusLabel }}
                        </span>
                    </p>
                    <p><strong>Дата подачи:</strong> {{ $application->created_at->format('d.m.Y H:i') }}</p>
                    @if($application->updated_at != $application->created_at)
                        <p><strong>Последнее обновление:</strong> {{ $application->updated_at->format('d.m.Y H:i') }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    @if($application->status === 'rejected' && $application->rejection_reason)
                        <div class="alert alert-danger">
                            <strong>❌ Причина отказа:</strong><br>
                            {{ $application->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('applications.my') }}" class="btn btn-secondary">← Назад к заявкам</a>
        </div>
    </div>
</div>
@endsection