@extends('layouts.admin')

@section('content')
    <h1>Create About</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('abouts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="tittle">Tittle:</label>
            <input type="text" id="tittle" name="tittle" value="{{ old('tittle') }}" required>
        </div>
        <div>
            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required>
        </div>
        <button type="submit">Create</button>
    </form>
@endsection
