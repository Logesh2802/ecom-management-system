@extends('layouts.layout')
@section('title')
    <title>Admin | Products </title>
@endsection
@section('content')

<div class="container bg-white shadow rounded m-4 p-4 ">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Products</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

    <table id="dataTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width:10%">ID</th>
                <th style="width:10%">Product</th>
                <th style="width:10%">Image</th>
                <th style="width:10%">Category</th>
                <th style="width:30%">Description</th>
                <th style="width:10%" >Status</th>
                <th style="width:20%">Action</th>
            </tr>
            <tr>
                <th><input type="text" id="filterID" class="form-control" placeholder="ID"></th>
                <th><input type="text" id="filterProduct" class="form-control" placeholder="Product"></th>
                <th></th> <!-- No filter for images -->
                <th>
                    <select id="filterCategory" class="form-control">
                        <option value="">All</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>    
                        @endforeach
                        
                    </select>
                </th>
                <th><input type="text" id="filterDescription" class="form-control" placeholder="Description"></th>
                <th>
                    <select id="filterStatus" class="form-control">
                        <option value="">All</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </th>
                <th></th> <!-- No filter for action buttons -->
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->name }}</td>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{$product->name}}" width="100">
                    @else
                        No Image
                    @endif
                </td>
                <td>
                    @foreach($categories as $category)
                    @if ($product->category_id == $category->category_id)
                        {{ $category->name }}
                    @endif
                @endforeach
                </td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->status == 1 ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-sm btn-warning">Edit</a>
                
                    <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete-btn" onclick="confirmDelete(this)">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection

@push('scripts')

<script>
    function confirmDelete(button) {
        if (confirm("Are you sure you want to delete this Product?")) {
            button.closest('form').submit(); // Submit form if user confirms
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

    // Filtering functionality
    let filters = {
        id: document.getElementById("filterID"),
        product: document.getElementById("filterProduct"),
        category: document.getElementById("filterCategory"),
        description: document.getElementById("filterDescription"),
        status: document.getElementById("filterStatus"),
    };

    Object.values(filters).forEach(filter => {
        filter.addEventListener("input", filterTable);
        filter.addEventListener("change", filterTable); // Ensures dropdown filters work
    });

    function filterTable() {
        let rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            let productId = row.children[0].innerText.toLowerCase();
            let productName = row.children[1].innerText.toLowerCase();
            let categoryText = row.children[3].innerText.trim().toLowerCase();
            let description = row.children[4].innerText.toLowerCase();
            let status = row.children[5].innerText.toLowerCase();

            let idFilter = filters.id.value.toLowerCase();
            let productFilter = filters.product.value.toLowerCase();
            let categoryFilter = filters.category.value; // Category ID (number)
            let descriptionFilter = filters.description.value.toLowerCase();
            let statusFilter = filters.status.value.toLowerCase();

            let matches =
                (idFilter === "" || productId.includes(idFilter)) &&
                (productFilter === "" || productName.includes(productFilter)) &&
                (categoryFilter === "" || categoryText.includes(filters.category.options[filters.category.selectedIndex].text.toLowerCase())) &&
                (descriptionFilter === "" || description.includes(descriptionFilter)) &&
                (statusFilter === "" || status.includes(statusFilter));

            row.style.display = matches ? "" : "none";
        });
    }
});

</script>
@endpush