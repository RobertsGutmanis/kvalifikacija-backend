<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Models\specifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){

        $products = Products::all();

        foreach ($products as $product){
            $product->category = Categories::where('id', $product->category_id)->first("category")->category;
        }

        return response()->json([
            'status'=>true,
            'data'=>$products
        ]);
    }

    public function store(Request $request)
    {
        Products::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'manufacturer'=>$request->manufacturer,
            'price'=>$request->price,
            'last_price'=>$request->last_price,
            'category_id'=>$request->category_id,
            'image_url'=>$request->image_url
        ]);


        return response()->json([
            'status'=>true,
            'message'=>'Product created!'
        ]);
    }

    public function show (string $id)
    {
        $specifications = specifications::where('product_id', $id)->get();
        $product = Products::where('id', $id)->first();

        return response()->json([
            "staus"=>true,
            "product"=>$product,
            "specification"=>$specifications
        ], 200);
    }

    public function categoryProducts(string $category)
    {
        $category_id = Categories::where('category', $category)->first()->id;

        $products_by_category = Products::where('category_id', $category_id)->get();


        return response()->json([
            "success"=>true,
            "data"=>$products_by_category,
        ], 200);
    }

    public function searchProduct(string $value)
    {
        $products = Products::where('name', $value)
            ->orWhere('name', 'like', '%' . $value . '%')->get();

        return response()->json([
            "success"=>true,
            "data"=>$products
        ], 200);
    }

    public function addProductSpec(Request $request)
    {
        specifications::create([
            "product_id"=>$request->product_id,
            "key"=>$request->key,
            "value"=>$request->value
        ]);

        return response()->json([
            "status"=>true,
            "message"=>"Specification created"
        ],200);
    }
}
