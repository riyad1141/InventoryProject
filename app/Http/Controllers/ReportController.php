<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
class ReportController extends Controller
{
    function ReportPage(): View{
        return view('pages.dashboard.report-page');
    }

    function SalesReport(Request $request): Response
    {
        $user_id=$request->header('id');
        $FormDate=date('Y-m-d',strtotime($request->FormDate));
        $ToDate=date('Y-m-d',strtotime($request->ToDate));

        $total=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $payable=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');
        $discount=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');
        $list=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->with('customer')->get();

        $data=['payable'=> $payable,'discount'=>$discount, 'total'=> $total, 'vat'=> $vat, 'list'=>$list,'FormDate'=>$request->FormDate,'ToDate'=>$request->FormDate];
        $pdf = Pdf::loadView('report.SalesReport',$data);
        return $pdf->download('invoice.pdf');

    }

}
