@extends('layouts.layout')
@section('title')
    <title>Admin | Products </title>
@endsection
@section('content')
<div class="container m-4 p-4 bg-white shadow rounded w-95">
    <h2 class="mb-4">Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ $product->category_id == $category->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" required>
            @error('quantity')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" id="image" class="form-control " style="border: none;" onchange="previewImage(event)">
            @error('image')<div class="text-danger">{{ $message }}</div>@enderror
            <div class="mt-2">
                <img id="imagePreview" src="{{ asset('storage/' . $product->image) }}" alt="Image Preview" class="img-fluid" style="max-width: 200px; {{ $product->image ? '' : 'display: none;' }}">
            </div>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            @error('description')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Update Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function(){
            const img = document.getElementById('imagePreview');
            img.src = reader.result;
            img.style.display = 'block';
        };
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush