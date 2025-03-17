<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('admin.products.index', compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Limit image size to 2MB
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|integer|exists:categories,category_id',
        ]);
    
        try {
            // Handle image upload if provided
            $imagePath = $request->file('image') ? $request->file('image')->store('products', 'public') : null;
    
            // Create the product
            Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'image' => $imagePath,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);
    
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $product_id)
{
    $product = Product::where('product_id',$product_id)->first(); // Fetch the product
    $categories = Category::all(); // Fetch all categories for dropdown
    return view('admin.products.edit', compact('product', 'categories'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $product_id)
{
    // Validate the request data
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('products')->ignore($product_id, 'product_id'),
        ],
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'image' => 'nullable|image',
        'description' => 'nullable|string',
        'category_id' => 'required|integer|exists:categories,category_id',
        'status' => 'required', // Adding status validation
    ]);

    $product = Product::findOrFail($product_id);

    // Handle image upload and delete the old image if a new one is uploaded
    if ($request->hasFile('image')) {
        // Delete the previous image from storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Store new image
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    // Update product details
    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'description' => $request->description,
        'category_id' => $request->category_id,
        'status' => $request->status, // Updating status field
        'image' => $product->image, // Ensure image field is updated properly
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id)
{
    $product = Product::find($product_id);

    if (!$product) {
        return redirect()->route('products.index')->with('error', 'Product not found.');
    }

    // Delete the image if it exists
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    // Delete the product
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
}

public function getFilteredProducts(Request $request)
{
    $query = Product::with('category'); // Ensure category is loaded

    if ($request->id) {
        $query->where('id', $request->id);
    }

    if ($request->product) {
        $query->where('name', 'LIKE', "%{$request->product}%");
    }

    if ($request->category) {
        $query->where('category_id', $request->category);
    }

    if ($request->description) {
        $query->where('description', 'LIKE', "%{$request->description}%");
    }

    if ($request->status !== null) {
        $query->where('status', $request->status == 'Active' ? 1 : 0);
    }

    $products = $query->get();

    return response()->json(['products' => $products]);
}
}
