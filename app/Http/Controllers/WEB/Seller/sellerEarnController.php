<?php

namespace App\Http\Controllers\WEB\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sellerEarn;
use App\Models\Setting;
use App\Models\Vendor;
use App\Models\User;
use Auth;
use App\Models\Order;
use DB;
use App\Models\OrderAddress;

class sellerEarnController extends Controller
{
    /**
     * Show Authenticate Seller Earn.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function show_seller_earn(Request $request){
         
        $seller_id = Auth::user()->id;
        $setting = Setting::first();
        
        // Calculate total earnings grouped by order_id
        
        $seller_earn_data = SellerEarn::leftJoin("orders as o", "o.id", "seller_earns.order_id")
                            ->select("seller_earns.order_id", 
                                DB::raw("SUM(seller_earns.paid) as paid"),
                                DB::raw("SUM(seller_earns.payable_earn) as total_payable_earn"), 
                                DB::raw("SUM(seller_earns.earning) as total_earn"), 
                                DB::raw("SUM(seller_earns.seller_sell_price) as total_sell_price"),
                                DB::raw("SUM(seller_earns.product_price) as total_price"),
                                "o.created_at","o.advance_amount","o.shipping_cost","o.order_status")
                            ->where('seller_earns.seller_id', $seller_id)
                            ->groupBy('seller_earns.order_id', 'o.created_at')
                            ->get();

        return view('seller.seller_earn', compact('seller_earn_data', 'setting'));
     }
     
     public function seller_invoice(Request $request, $order_id) {
        
        $seller_id = Auth::user()->id; 
        $seller_info = Vendor::where('user_id', $seller_id)->first();
        $user_info = User::where('id', $seller_id)->first();
        $setting = Setting::first(); 
        $order = Order::with(['orderProducts' => function($row) use($seller_id) {
                                $row->where('seller_id', $seller_id);
                        }])   
                    ->findOrFail($order_id);
     
        return view('seller.seller_invoice',compact('seller_info','setting' , 'user_info','order'));
     }
     
}
