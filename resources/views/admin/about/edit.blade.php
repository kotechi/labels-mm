@extends('layouts.admin')

@section('content')
    <h1>Edit About</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('abouts.update', $about->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div>
            <label for="tittle">Tittle:</label>
            <input type="text" id="tittle" name="tittle" value="{{ old('tittle', $about->tittle) }}" required>
        </div>
        <div>
            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi', $about->deskripsi) }}</textarea>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->tittle }}" width="100">
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
