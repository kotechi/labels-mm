@extends('layouts.admin')

@section('content')
    <h1>Create Contact</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf
        <div>
            <label for="tittle">Tittle:</label>
            <input type="text" id="tittle" name="tittle" value="{{ old('tittle') }}" required>
        </div>
        <div>
            <label for="link">Link:</label>
            <input type="text" id="link" name="link" value="{{ old('link') }}" required>
        </div>
        <button type="submit">Create</button>
    </form>
@endsection
