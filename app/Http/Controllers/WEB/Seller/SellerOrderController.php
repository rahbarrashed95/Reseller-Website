<?php

namespace App\Http\Controllers\WEB\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\OrderProduct;
use App\Models\OrderProductVariant;
use App\Models\OrderAddress;
use Auth;
class SellerOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $seller = Auth::guard('web')->user()->seller;
        $orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->paginate(15);
        $title = trans('admin_validation.All Orders');
        $setting = Setting::first();
        return view('seller.order', compact('orders','title','setting'));
    }

    public function pendingOrder(){

        $seller = Auth::guard('web')->user()->seller;

        $pending_orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->where('order_status',0)->paginate(15);

        // $pending_orders = Order::with('user', 'assign', 'orderProducts.product')->whereHas('user', function ($query) {
        // $query->whereHas('roles', function ($roleQuery) {
        //     $roleQuery->where('name', 'Seller');
        // });
        // })->where('order_status', 0)->where('order_status', 0)->where('user_id', $seller->user_id)->get();

        $title = trans('admin_validation.Pending Orders');
        $setting = Setting::first();
        return view('seller.pending_order', compact('pending_orders','title','setting'));
    }

    public function processOrder(){
        $seller = Auth::guard('web')->user()->seller;
        $processing_orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->where('order_status',1)->paginate(15);
        $title = trans('admin_validation.Pregress Orders');
        $setting = Setting::first();
        return view('seller.processing_order', compact('processing_orders','title','setting'));
    }

    public function onholdOrder(){
        $seller = Auth::guard('web')->user()->seller;
        $onhold_orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->where('order_status',5)->paginate(15);
        $title = trans('admin_validation.Pregress Orders');
        $setting = Setting::first();
        return view('seller.onhold_order', compact('onhold_orders','title','setting'));
    }

    public function courierOrder(){
        $seller = Auth::guard('web')->user()->seller;
        $courier_orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->where('order_status',2)->paginate(15);
        $title = trans('admin_validation.Delivered Orders');
        $setting = Setting::first();
        return view('seller.courier_order', compact('courier_orders','title','setting'));
    }

    public function completedOrder(){
        $seller = Auth::guard('web')->user()->seller;
        $completed_orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->where('order_status',3)->paginate(15);
        $title = trans('admin_validation.Completed Orders');
        $setting = Setting::first();
        return view('seller.completed_orders', compact('completed_orders','title','setting'));
    }

    public function returnOrder(){
        $seller = Auth::guard('web')->user()->seller;
        $return_orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->where('order_status',6)->paginate(15);
        $title = trans('admin_validation.Declined Orders');
        $setting = Setting::first();
        return view('seller.return_order', compact('return_orders','title','setting'));
    }

    public function cancellOrder(){
        $seller = Auth::guard('web')->user()->seller;
        $cancell_orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->user_id]);
        })->orderBy('id','desc')->where('order_status',4)->paginate(15);
        $title = trans('admin_validation.Declined Orders');
        $setting = Setting::first();
        return view('seller.cancell_order', compact('cancell_orders','title','setting'));
    }

    public function partialOrder() {

        $user = Auth::guard('web')->user();

        if ($user) {
            $orders = Order::with('user')
                ->whereHas('orderProducts', function ($query) use ($user) {
                    $query->where('seller_id', $user->id);
                })
                ->where('order_status', 8)
                ->orderBy('id', 'desc')
                ->paginate(15);
        }


        // $seller = Auth::guard('web')->user()->seller;

        // $orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
        //     $query->where(['seller_id' => $seller->id]);
        // })->orderBy('id','desc')->where('order_status',7)->paginate(15);
        // dd($orders);
        $title = trans('admin_validation.Pending Orders');
        $setting = Setting::first();
        return view('seller.order', compact('orders','title','setting'));
    }

    public function cashOnDelivery(){
        $seller = Auth::guard('web')->user()->seller;
        $orders = Order::with('user')->whereHas('orderProducts',function($query) use ($seller){
            $query->where(['seller_id' => $seller->id]);
        })->orderBy('id','desc')->where('cash_on_delivery',1)->paginate(15);

        $title = trans('admin_validation.Cash On Delivery');
        $setting = Setting::first();
        return view('seller.order', compact('orders','title','setting'));
    }

    public function show($id){
        $order = Order::with('user','orderProducts.orderProductVariants','orderAddress')->find($id);

        $setting = Setting::first();
        return view('seller.show_order',compact('order','setting'));
    }

    function getRedxAreaList($by = null, $value = null)
  {


      $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => $this->redx_api_access_token,
       ])->get($this->redx_api_base_url.'areas');

       $areas = $response->json()['areas'];
       return $areas;
  }
  function createRedxParcel($item)
  {
      //$area = $this->getRedxAreaList('post_code', $item->zip_code)[0];

      $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => $this->redx_api_access_token,
            'Content-Type' => 'application/json'
        ])->post($this->redx_api_base_url.'parcel', [
            "customer_name" 		 => $item->orderAddress->shipping_name ?? "Unknown User",
            "customer_phone"         => $item->orderAddress->shipping_phone ?? "01700000000",
            "delivery_area"          => $item->area_name, // delivery area name
            "delivery_area_id"       => $item->area_id, // area id
            "customer_address"       => $item->orderAddress->shipping_address,
            "merchant_invoice_id"    => $item->order_id,
            "cash_collection_amount" => $item->total_amount,
            "parcel_weight"          => "500", //parcel weight in gram
            "instruction"            => "",
            "value"                  => $item->total_amount, //compensation amount
            "pickup_store_id"        => 0, // store id
            "parcel_details_json"    => []
        ]);

    return $response->json();
  }

    public function edit($id)
    {
    //   if(!auth()->user()->can('admin.order-edit')){
    //         abort(403, 'Unauthorized action.');
    //     }

        $order = Order::with('orderProducts','orderProducts.product')->where('id', $id)->first();
        $areas = $this->getRedxAreaList();
      	// $stores = $this->getPathaoStoreList();
      	$cities = $this->getPathaoCityList();
        $couriers=Courier::all();
        $shippings = Shipping::all();
        return view('admin.edit_order', compact('order', 'areas', 'cities', 'couriers','shippings'));
    }
}
