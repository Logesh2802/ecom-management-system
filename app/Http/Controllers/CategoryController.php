<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categories = Category::all();
    return view('admin.categories.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'description' => 'nullable|string|max:1000',
    ]);

    // Create a new category
    Category::create([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    // Redirect with success message
    return redirect()->route('categories.index')->with('success', 'Category created successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category =  Category::where('category_id',$id)->first();
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$category_id)
{
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('categories')->ignore($category_id, 'category_id'),
        ],
        'description' => 'nullable|string|max:1000',
    ]);
    $category = Category::where('category_id', $category_id)->first();
    if (!$category) {
        return redirect()->route('categories.index')->with('error', 'Category not found.');
    }
    $category->update([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id)
{
    try {
        $category = Category::where('category_id', $category_id)->first();

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        // Delete related records first
        Product::where('category_id', $category_id)->delete();

        // Now delete the category
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->route('categories.index')->with('error', 'Cannot delete category: It is referenced in another table.');
    } catch (\Exception $e) {
        return redirect()->route('categories.index')->with('error', 'Failed to delete category. Error: ' . $e->getMessage());
    }
}
}
