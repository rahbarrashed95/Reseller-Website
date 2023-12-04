<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\orderPayment;
use App\Models\OrderProduct;
use App\Models\orderInvoice;
use App\Models\Setting;
use App\Models\sellerAccount;
use App\Models\sellerEarn;
use DB;

class orderPaymentController extends Controller
{
    public function order_payment($seller_id, $unique_key) {
        // $seller_payment_data = orderInvoice::leftJoin("orders as o", "o.id", "=", "order_invoices.order_id")
           
        //     ->leftJoin("users as u", "u.id", "=", "order_invoices.seller_id")
        //     ->leftJoin("vendors as v", "v.user_id", "=", "u.id")
        //     ->leftJoin("seller_earns as se", "se.order_id","=","o.id")
        //     ->select(
        //         "seller_id",
        //         "u.phone as phone",
        //         "v.shop_name as shop_name",
        //         "order_invoices.unique_key",
        //         DB::raw("SUM(order_invoices.amount) as total_amount"),
        //         DB::raw("GROUP_CONCAT(order_invoices.order_id) as order_ids"),
        //         "o.created_at"
        //     )
        //     ->where('unique_key', $unique_key)
        //     ->groupBy('order_invoices.unique_key')
        //     ->first();
        
        // $seller_payment_data = orderInvoice::leftJoin("orders as o", "o.id", "=", "order_invoices.order_id")
        //     ->leftJoin("users as u", "u.id", "=", "order_invoices.seller_id")
        //     ->leftJoin("vendors as v", "v.user_id", "=", "u.id")
        //     ->leftJoin("seller_earns as se", "se.order_id", "=", "o.id")
        //     ->select(
        //         "order_invoices.seller_id", // Explicitly specify the table alias
        //         "u.phone as phone",
        //         "v.shop_name as shop_name",
        //         "order_invoices.unique_key",
        //         DB::raw("SUM(order_invoices.amount) as total_amount"),
        //         DB::raw("GROUP_CONCAT(order_invoices.order_id) as order_ids"),
        //         "o.created_at"
        //     )
        //     ->where('order_invoices.unique_key', $unique_key)
        //     ->groupBy('order_invoices.unique_key')
        //     ->first();
            
            $seller_payment_data = orderInvoice::leftJoin("orders as o", "o.id", "=", "order_invoices.order_id")
                ->leftJoin("users as u", "u.id", "=", "order_invoices.seller_id")
                ->leftJoin("vendors as v", "v.user_id", "=", "u.id")
                ->leftJoin("seller_earns as se", "se.order_id", "=", "o.id")
                ->select(
                    "order_invoices.seller_id",
                    "u.phone as phone",
                    "v.shop_name as shop_name",
                    "order_invoices.unique_key",
                    DB::raw("SUM(order_invoices.amount) as total_amount"),
                    DB::raw("SUM(se.payable_earn) as total_payable_earn"), // Retrieve total earnings
                    DB::raw("GROUP_CONCAT(order_invoices.order_id) as order_ids"),
                    "o.created_at"
                )
                ->where('order_invoices.unique_key', $unique_key)
                ->groupBy('order_invoices.unique_key')
                ->first();
            
        $title = trans('admin_validation.Seller Payment');
        $setting = Setting::first();
        return view('admin.order_payment', compact('seller_payment_data','title','setting'));
            
    }
    
    public function pay_order(Request $request) {
        $data=$request->validate([
             'payment_title'=> '',
             'payment_id'=> '',
             'payment_no' => '',
             'payment_date' => '',
             'seller_id' => '',
             'unique_key' => '',
             'payment_amount' => ''
        ]);
        
        orderPayment::create($data);
        
        $orderIds = explode(',', $request->order_id);
        
        foreach($orderIds as $id) {
            $ord_pro = OrderProduct::where('order_id', $id)->where('seller_id', $request->seller_id)->get();
            foreach($ord_pro as $op) {
                
                $seller_account_data = sellerAccount::where('seller_id', $request->seller_id)->where('order_product_id', $op->id)->first();
                $seller_earn_data = sellerEarn::where('seller_id', $request->seller_id)->where('order_product_id', $op->id)->first();
                echo $seller_account_data->earning;
                echo '<br/>';
                $seller_account_data->update([
                    'complete_payment' =>  $seller_account_data->earning,
                    'earning' => 0
                ]);
                
                $seller_earn_data->update([
                    'paid' => $seller_earn_data->payable_earn,
                    'payable_earn' => 0,
                    'earning' => 0
                ]);
                
            }
        }
        
        $notification = trans('admin_validation.Payment Complete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
        
    }
}
