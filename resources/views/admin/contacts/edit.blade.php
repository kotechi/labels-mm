@extends('layouts.admin')

@section('content')
    <h1>Edit Contact</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div>
            <label for="tittle">Tittle:</label>
            <input type="text" id="tittle" name="tittle" value="{{ old('tittle', $contact->tittle) }}" required>
        </div>
        <div>
            <label for="link">Link:</label>
            <input type="text" id="link" name="link" value="{{ old('link', $contact->link) }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
