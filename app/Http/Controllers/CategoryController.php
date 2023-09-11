<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function CategoryPage (): View {
        return view('pages.dashboard.category-page');
    }

    public function CategoryList (Request $request) {
        $id = $request->header('id');
        return Category::where('user_id','=',$id)->get();
    }

    function CategoryByID(Request $request){
        $category_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id','=',$category_id)->where('user_id','=',$user_id)->first();
    }

    public function CategoryCreate (Request $request) {
        $id = $request->header('id');
        $name = $request->input('name');
        return Category::create([
            'name' => $name,
            'user_id' => $id
        ]);
    }

    public function CategoryUpdate (Request $request) {
        $id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('user_id','=',$id)->where('id','=',$category_id)->update([
            'name' => $request->input('name')
        ]);
    }

    public function CategoryDelete (Request $request) {
        $id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('user_id','=',$id)->where('id','=',$category_id)->delete();
    }




}
