@extends('layouts.layout')
@section('title')
    <title>Admin | Categories </title>
@endsection

@section('content')
<div class="container m-4 p-4 bg-white shadow rounded w-95">
    <h2 class="mb-4">Create Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('categories.update',$category->category_id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="6" >{{$category->description}}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection