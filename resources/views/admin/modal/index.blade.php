@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Modal List</h1>
    <a href="{{ route('modals.create') }}" class="btn btn-primary">Create Modal</a>
    <table id="modalTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modals as $modal)
            <tr>
                <td>{{ $modal->id }}</td>
                <td>{{ $modal->nama }}</td>
                <td>{{ $modal->harga }}</td>
                <td>{{ $modal->jumlah }}</td>
                <td>
                    <a href="{{ route('modals.edit', $modal->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('modals.destroy', $modal->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#modalTable').DataTable();
    });
</script>
@endsection
