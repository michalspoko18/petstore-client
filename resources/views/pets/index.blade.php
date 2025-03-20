@extends('layouts.app')

@section('content')
    <h1>Lista zwierząt</h1>
    <a href="{{ route('pets.create') }}" class="btn btn-primary mb-3">Dodaj nowe zwierzę</a>

    <div class="row">
        @forelse($pets as $pet)
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    @if(!empty($pet['photoUrls'][0]))
                        <img src="{{ $pet['photoUrls'][0] ?? '' }}" class="card-img-top" alt="{{ $pet['name'] ?? 'Brak nazwy' }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet['name'] ?? 'Brak nazwy' }}</h5>
                        <p class="card-text">
                            <strong>ID:</strong> {{ $pet['id'] ?? 'Nieznane' }}<br>
                            <strong>Status:</strong> {{ $pet['status'] ?? 'Nieznany' }}<br>
                            @if(isset($pet['category']['name']))
                                <strong>Kategoria:</strong> {{ $pet['category']['name'] }}
                            @endif
                        </p>
                        <div class="btn-group d-flex flex-md-column flex-xl-row">
                            <a href="{{ route('pets.show', $pet['id']) }}" class="btn">Szczegóły</a>
                            <a href="{{ route('pets.edit', $pet['id']) }}" class="btn">Edytuj</a>
                            <form action="{{ route('pets.destroy', $pet['id']) }}" class="text-center" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć to zwierzę?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn">Usuń</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Brak zwierząt do wyświetlenia</div>
            </div>
        @endforelse
    </div>
@endsection
