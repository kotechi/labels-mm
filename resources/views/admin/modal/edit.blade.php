@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Modal</h1>
    <form action="{{ route('modals.update', $modal->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $modal->nama }}" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $modal->harga }}" required>
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $modal->jumlah }}" required>
        </div>
        <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
