@extends('layouts.layout')
@section('title')
    <title>Admin | Categories </title>
@endsection

@section('content')

<div class="container bg-white shadow rounded m-4 p-4 w-95">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Create Category</a>
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
                <th style="width:20%">Category</th>
                <th style="width:50%">Description</th>
                <th style="width:20%">Action</th>
            </tr>
            <tr>
                <th><input type="text" id="filterCategoryID" class="form-control" placeholder="ID"></th>
                <th><input type="text" id="filterCategoryName" class="form-control" placeholder="Name"></th>
                <th><input type="text" id="filterCategoryDescription" class="form-control" placeholder="Description"></th>
                <th></th> <!-- No filter for action buttons -->
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->category_id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-sm btn-warning">Edit</a>
                
                    <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" class="d-inline delete-form">
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
        if (confirm("Are you sure you want to delete this category?")) {
            button.closest('form').submit(); // Submit form if user confirms
        }
    }
</script>

@endpush