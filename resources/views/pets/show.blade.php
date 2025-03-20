@extends('layouts.app')

@section('content')
    <h1>Szczegóły zwierzęcia</h1>
    
    <div class="card mb-4">
        @if(!empty($pet['photoUrls'][0]))
            <img src="{{ $pet['photoUrls'][0] }}" class="card-img-top" alt="{{ $pet['name'] }}">
        @endif
        <div class="card-body">
            <h2 class="card-title">{{ $pet['name'] }}</h2>
            <p class="card-text">
                <strong>ID:</strong> {{ $pet['id'] }}<br>
                <strong>Status:</strong> {{ $pet['status'] }}<br>
                @if(isset($pet['category']['name']))
                    <strong>Kategoria:</strong> {{ $pet['category']['name'] }}<br>
                @endif
            </p>
        </div>
        <div class="card-footer">
            <a href="{{ route('pets.index') }}" class="btn btn-secondary">Powrót do listy</a>
            <a href="{{ route('pets.edit', $pet['id']) }}" class="btn">Edytuj</a>
            <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć to zwierzę?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn">Usuń</button>
            </form>
        </div>
    </div>
@endsection
