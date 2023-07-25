<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\models\User;
use App\Models\Role;




class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function home()
    {
        return 'home page';
    }
    public function index()
    {   
       
        
           $products = Products::all();

            if($products->count()>0){
            return response()->json([
                'status' => 200,
                'products' => $products
            ], 200);
            }else{
           return response()->json([
                'status' => 404,
                'products' => 'no products found'
            ], 404);
        }
        
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'name'=> 'required|min:4',
           'desc'=> 'required|min:4',
           'price'=> 'required|min:2'
         ]);      
       
             $products = Products::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'price' => $request->price,
            ]);           
         

         if($products){
            return response()->json([
                'status' => 200,
                'message' => 'products created succesfully'
            ], 200);
         }else{
            return response()->json([
                'status' => 500,
                'message' => 'something went wrong'
            ], 500);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::find($id);
        if($product){
             return response()->json([
                'status' => 200,
                'product' => $product
            ], 200);
        }else{
             return response()->json([
                'status' => 404,
                'products' => 'no products found with  id:'.$id
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $this->validate($request, [
           'name'=> 'required|min:4',
           'desc'=> 'required|min:4',
           'price'=> 'required|min:2'
         ]);      
             $products = Products::find($id);
             $products->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'price' => $request->price,
            ]);           
         

         if($products){
            return response()->json([
                'status' => 200,
                'message' => ['product'.$id ,'updated succesfully']
            ], 200);
         }else{
            return response()->json([
                'status' => 500,
                'message' => 'no products found with  id:'.$id
            ], 500);
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Products::find($id);
        if($products){
            $products->delete();
            return response()->json([ 
                'message' => ['product '.$id ,'deleted succesfully']
            ], 200);
         }else{
            return response()->json([
                'status' => 500,
                'message' => 'no products found with  id:'.$id
            ], 500);
         }
    }
}
