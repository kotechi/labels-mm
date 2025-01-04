<table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
    <thead>
        <tr>
            <th data-priority="1">Name</th>
            <th data-priority="2">Price</th>
            <th data-priority="3">Link</th>
            <th data-priority="4">deskripsi</th>
            <th data-priority="5">Image</th>
            <th data-priority="6">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$product->nama}}</td>
            <td>{{$product->harga}}</td>
            <td>{{$product->link}}</td>
            <td>{{$product->deskripsi}}</td>
            <td>{{$product->image}}</td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
