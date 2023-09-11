<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ProductController extends Controller
{

    public function ProductPage (): View {
        return view('pages.dashboard.product-page');
    }

    public function CreateProduct (Request $request) {

        try {
            $user_id = $request->header('id');

            $image = $request->file('image');

            $time = time();
            $file_name = $image->getClientOriginalName();
            $image_name = "{$user_id}-{$time}-{$file_name}";

            $image_url = "uploads/{$image_name}";

            $image->move(public_path('uploads'),$image_name);


            return Product::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'image_url' => $image_url,
                'category_id' => $request->input('category_id'),
                'user_id' => $user_id
            ]);
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    public function ProductById (Request $request) {
        try {
            $user_id = $request->header('id');
            $product_id = $request->input('id');
            return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->first();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    public function ProductList (Request $request) {
        try {
            $user_id = $request->header('id');
            return Product::where('user_id','=',$user_id)->get();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    public function ProductDelete (Request $request) {
        try {
            $product_id = $request->input('id');
            $user_id = $request->header('id');
            $file_path = $request->input('file');
            File::delete($file_path);
            return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->delete();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    public function UpdateProduct (Request $request) {

        try {
            $user_id = $request->header('id');
            $product_id = $request->input('id');

            if ($request->hasFile('image')){
                $image = $request->file('image');
                $time = time();
                $file_name = $image->getClientOriginalName();
                $image_name = "{$user_id}-{$time}-{$file_name}";
                $image_url = "uploads/{$image_name}";
                $image->move(public_path('uploads'),$image_name);
                $file_path = $request->input('file_path');
                File::delete($file_path);

                return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->update([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'unit' => $request->input('unit'),
                    'image_url' => $image_url,
                    'category_id' => $request->input('category_id'),
                ]);

            }else{
                return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->update([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'unit' => $request->input('unit'),
                    'category_id' => $request->input('category_id')
                ]);
            }
        }catch (Exception $exception){
            return $exception->getMessage();
        }


    }

}
