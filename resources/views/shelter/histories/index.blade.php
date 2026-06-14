@extends('layouts.app')

@section('title', 'История питомца: ' . $pet->name)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>История питомца: {{ $pet->name }}</h1>
            <a href="{{ route('shelter.pets.edit', $pet) }}" class="btn btn-outline-secondary mt-2">
                <i class="bi bi-arrow-left"></i> Назад к питомцу
            </a>
        </div>
        <a href="{{ route('shelter.pets.histories.create', $pet) }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Добавить запись
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">📋 Медицинская карта</h5>
        </div>
        <div class="card-body">
            @forelse($histories as $history)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-{{ $history->type_color }} fs-6">
                                {{ $history->type_label }}
                            </span>
                            <strong class="ms-2">{{ $history->formatted_date }}</strong>
                        </div>
                        <div>
                            <a href="{{ route('shelter.pets.histories.edit', [$pet, $history]) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('shelter.pets.histories.destroy', [$pet, $history]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить запись?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Описание:</strong> {{ $history->description }}</p>
                        @if($history->veterinarian)
                            <p class="mb-0"><strong>Ветеринар:</strong> {{ $history->veterinarian }}</p>
                        @endif
                        <hr>
                        <small class="text-muted">
                            Добавлено: {{ $history->created_at->format('d.m.Y H:i') }}
                            @if($history->created_at != $history->updated_at)
                                | Обновлено: {{ $history->updated_at->format('d.m.Y H:i') }}
                            @endif
                        </small>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle fs-1"></i>
                    <p>У питомца пока нет записей в истории.</p>
                    <a href="{{ route('shelter.pets.histories.create', $pet) }}" class="btn btn-primary">
                        Добавить первую запись
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-4">
        {{ $histories->links() }}
    </div>
</div>
@endsection

<style>
.card-header .badge {
    font-size: 0.9rem;
    padding: 0.5rem 0.8rem;
}
</style>