<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{

    public function CustomerPage (): View {
        return view('pages.dashboard.customer-page');
    }
    public function CustomerCreate (Request $request): string
    {
        try {
            $id = $request->header('id');
            Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'user_id' => $id
            ]);
            return "Success";
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    public function CustomerUpdate (Request $request) {
        $id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id','=',$id)->where('id','=',$customer_id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
        ]);
    }

    public function CustomerDelete (Request $request) {
        $id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id','=',$id)->where('id','=',$customer_id)->delete();
    }

    public function CustomerById (Request $request) {
        $id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id','=',$id)->where('id','=',$customer_id)->first();
    }

    public function CustomerList (Request $request) {
        $id = $request->header('id');
        return Customer::where('user_id','=',$id)->get();
    }

}
