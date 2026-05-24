@extends('layouts.app')

@section('title', $pet->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($pet->primaryPhoto)
                <img src="{{ asset('storage/' . $pet->primaryPhoto->photo_path) }}" class="img-fluid rounded" alt="{{ $pet->name }}">
            @else
                <div class="bg-secondary text-white text-center p-5 rounded">
                    <i class="bi bi-camera" style="font-size: 3rem;"></i>
                    <p>Нет фото</p>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $pet->name }}</h1>
            <p><strong>Вид:</strong> {{ $pet->category->name ?? 'Не указан' }}</p>
            <p><strong>Порода:</strong> {{ $pet->breed ?? 'Не указана' }}</p>
            <p><strong>Возраст:</strong> {{ $pet->age_estimate ?? 'Не указан' }}</p>
            <p><strong>Пол:</strong> {{ $pet->gender === 'male' ? 'Мальчик' : 'Девочка' }}</p>
            <p><strong>Описание:</strong> {{ $pet->description ?? 'Нет описания' }}</p>
            
            <a href="{{ route('applications.apply', $pet) }}" class="btn btn-success">Хочу усыновить!</a>
        </div>
    </div>
</div>
@endsection