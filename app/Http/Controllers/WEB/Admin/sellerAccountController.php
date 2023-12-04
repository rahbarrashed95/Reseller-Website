<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sellerAccount;
use DB;
use App\Models\Setting;

class sellerAccountController extends Controller
{
    public function sellersReport() {
        $seller_earn_data = sellerAccount::leftJoin("users as u", "u.id", "seller_accounts.seller_id")
            ->select("u.name","u.id",
                DB::raw("SUM(seller_accounts.complete_payment) as total_complete_payment"), 
                DB::raw("SUM(seller_accounts.pending_payment) as total_pending_payment"),
                DB::raw("SUM(seller_accounts.earning) as total_earning"),
                DB::raw("SUM(seller_accounts.pending_delivery) as total_pending_delivery"),
                DB::raw("SUM(seller_accounts.pending_earning) as total_pending_earning"))
            ->groupBy('seller_accounts.seller_id')
            ->get();
        
        $title = trans('admin_validation.All Orders');
        $setting = Setting::first();
        
        return view('admin.seller_report', compact('seller_earn_data','title','setting'));
        
    }
}

