<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Products; 
use App\Models\Category; 
use App\Models\category_product; 
use App\Models\images; 
use Auth;

class ProductController extends Controller
{
    //

    public function show()
    {    
        $category_list = Category::all();
        $data = Products::with('categories')->get();
        
        return view('admin.product_list', [
            'data' => $data,
            'list_category' => $category_list
        ]);
    }

    

    // Store the new product
    public function store(Request $request)
    {
        $requested_data = $request->all();
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
        ]);
    
        $product = new Products();
        $product->name = $validatedData['product_name'];
        $product->user_id = Auth::user()->id;
        $product->save(); 
    
        foreach ($requested_data['category_id'] as $categoryId) {
            $category = new category_product();
            $category['category_id'] = $categoryId;
            $category['product_id'] = $product->id; 
            $category->save();
        }
    
        foreach ($requested_data['image_path'] as $file) {
            if ($request->file('image_path')) {
                $extension = $file->getClientOriginalExtension();
                $file_name = $file->getClientOriginalName() . '' . time() . '' . rand(1000000, 9999999) . '.' . $extension;
                $filePath = $file->storeAs('product_file', $file_name, 'public');
                $posted_data['image_path'] = 'storage/product_file/' . $file_name;
    
                $images_obj = new images();
                $images_obj['product_id'] = $product->id;
                $images_obj['image_path'] = $posted_data['image_path'];
                $images_obj->save();
            }
        }
        // echo '<pre>'; print_r(variable); echo '<pre>'; exit;

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
            'product' => $product,  

        ]);
    }
    

    //
    public function all_products():Response
    {
         $data=Products::paginate(10);
         return Response(['data' => $data],200);
    }
    
}