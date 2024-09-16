<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category; 

class CategoryController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $existingCategory = Category::where('name', $request->category_name)->first();
        if ($existingCategory) {
            return response()->json(['error' => 'Category already exists'], 409); 
        }

        $newCategory = Category::create([
            'name' => $request->category_name,
        ]);

        return response()->json(['success' => 'Category added successfully.', 'category' => $newCategory], 201); 
    }

    public function show()
    {
         $data=Category::all();
         return view('admin.category_list', ['data' => $data]);     

    }

    public function destroy($id)
    {
        $category = Category::find($id);
        
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['success' => 'Category deleted successfully.'], 200);
   }


   public function update(Request $request, $id)
{
    $request->validate([
        'category_name' => 'required|string|max:255',
    ]);

    $category = Category::find($id);

    if (!$category) {
        return response()->json(['error' => 'Category not found'], 404);
    }

    $existingCategory = Category::where('name', $request->category_name)->where('id', '!=', $id)->first();
    if ($existingCategory) {
        return response()->json(['error' => 'Category already exists'], 409); 
    }

    $category->name = $request->category_name;
    $category->save();

    return response()->json(['success' => 'Category updated successfully.'], 200);
}


   public function all_categories():Response
    {
         $data=Category::paginate(10);
         return Response(['data' => $data],200);
    }

}
