@extends('layouts.app')

@section('title', 'Каталог питомцев')

@section('content')
<div class="container">
    <h1 class="mb-4">Наши питомцы</h1>
    
    <div class="row">
        @forelse($pets as $pet)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet->name }}</h5>
                        <p class="card-text">
                            <strong>Порода:</strong> {{ $pet->breed ?? 'Не указана' }}<br>
                            <strong>Возраст:</strong> {{ $pet->age_estimate ?? 'Не указан' }}
                        </p>
                        <a href="{{ route('pets.show', $pet) }}" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Пока нет питомцев. Добавьте первого питомца!</div>
            </div>
        @endforelse
    </div>
    
    {{ $pets->links() }}
</div>
@endsection