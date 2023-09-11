<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoiceController extends Controller
{

    public function InvoicePage (): View {
        return view('pages.dashboard.invoice-page');
    }

    public function SalePage (): View {
        return view('pages.dashboard.sale-page');
    }

    public function InvoiceCreate (Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id' => $user_id,
                'customer_id' => $customer_id
            ]);
            $InvoiceId = $invoice->id;

            $products = $request->input('products');

            foreach ($products as $product){
                InvoiceProduct::create([
                   'user_id' => $user_id,
                   'invoice_id' => $InvoiceId,
                    'product_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'sale_price' => $product['sale_price'],
                ]);
            }
            DB::commit();
            return response()->json([
               'status' => 'success',
               'message' => 'Invoice Created Successfully Completed'
            ]);
        }catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invoice Failed',
                'Exception' => $exception->getMessage()
            ]);
        }
    }

    public function InvoiceSelect (Request $request) {
        $user_id = $request->header('id');
        return Invoice::where('user_id','=',$user_id)->with('customer')->get();
    }

    public function InvoiceDetails (Request $request): array
    {
        $user_id = $request->header('id');

        $CustomerDetails = Customer::where('user_id','=',$user_id)->where('id','=',$request->input('customer_id'))->first();

        $InvoiceTotal = Invoice::where('user_id','=',$user_id)->where('id','=',$request->input('invoice_id'))->first();

        $InvoiceProduct = InvoiceProduct::where('user_id','=',$user_id)->where('invoice_id','=',$request->input('invoice_id'))->get();

        return array(
            'Customer' => $CustomerDetails,
            'Invoice' => $InvoiceTotal,
            'Product' => $InvoiceProduct,
        );
    }


    public function InvoiceDelete (Request $request): int
    {

        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            InvoiceProduct::where('user_id','=',$user_id)->where('invoice_id','=',$request->input('invoice_id'))->delete();
            Invoice::where('id','=',$request->input('invoice_id'))->delete();
            DB::commit();
            return 1;
        }catch (Exception $exception){
            DB::rollBack();
            return 0;
        }
    }




}
