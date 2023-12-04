@extends('seller.master_layout')
@section('title')
<title>{{__('admin.Invoice')}}</title>
@endsection
<style>
        
        @media print {
            .section-header,
            #sidebar-wrapper,
            .print-area,
            .main-footer,
            .additional_info {
                display:none!important;
            }
            .status_section {
                display:none!important;
            }
        }
        
        /*.section-header,*/
        /*.order-status,*/
        /*#sidebar-wrapper,*/
        /*.print-area,*/
        /*.main-footer {*/
        /*    display:none!important;*/
        /*}*/
        
        .invoice {
            width: 75%;
        }
        
        .print-area {
            width: 88%;
            margin: 0 auto;
        }
        
        .invoice-print {
            margin: 0 auto;
        }
    
    
</style>
@section('seller-content')
      <!-- Main Content -->
      <div class="main-content">
       <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Invoice')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Invoice')}}</div>
            </div>
          </div>
          <div class="section-body">
            <div class="invoice">

            <div class="invoice-print">
                <div class="row">
                        <div class="col-md-6 img_section">
                            <h2 class="invoice-title"><img src="{{ asset($setting->logo) }}" alt="" width="200px"></h2>
                        </div>
                </div>
                    
                    <div class="row" style="border:1px solid black;width: 95%;margin:0 auto;">
                        
                      <div class="col-md-6" style="border-right:1px solid black">
                        <address>
                          <strong>{{__('Seller Information')}} :</strong><br>
                          {{ $seller_info->shop_name }}<br/>
                          {{ $seller_info->address }} <br/>
                          {{ $user_info->phone }}
                        </address>
                      </div>
                      
                      <div class="col-md-6" style="border-right:1px solid black">
                        <address>
                          <strong>{{__('Ship To')}} :</strong><br>
                          {{ $order->orderAddress->shipping_name }}<br/>
                          {{ $order->orderAddress->shipping_address }}<br/>
                          {{ $order->orderAddress->shipping_phone }}<br/>
                        </address>
                      </div>
                      
                    </div>
                    
              </div>

              <div class="col-lg-12 mt-3 print-area">
                            <table class="table table-centered table-nowrap mb-0" id="product_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Resell Price</th>
                                        <th>Wholesell Price</th>
                                        <th>Payable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $total_payable = 0; $total_earns = 0;  
                                    @endphp
                                    @foreach($order->orderProducts as $index => $line)
                                        @php    
                                            $earn = ($line->resell_price * $line->qty) - ($line->unit_price * $line->qty) - ($order->advance_amount); 
                                            $total_earns +=$earn;     
                                        @endphp
                                        <tr>
                                            <td>{{ $line->order_id }}</td>
                                            <td>{{ $line->created_at->format('d F, Y') }}</td>
                                            <td>{{ $line->product->name }}</td>
                                            <td>{{ $line->qty }}</td>
                                            <td>{{ $line->resell_price }}</td>
                                            <td>{{ $line->unit_price }}</td>
                                            <td>{{ $earn }}</td>
                                        </tr>
                                    @endforeach
                                 </tbody>
                                 <tbody>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>Sub Total : {{ $total_earns + $order->shipping_cost }}</td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>Delivery Charge: {{ $order->shipping_cost }}</td>
                                     </tr>
                                     <tr>
                                        
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>Payable : {{ $total_earns }}</td>
                                     </tr>
                                     
                                 </tbody>
                                 
                            </table>
                            
                            <style>
                                .total_calculation {
                                        border: 1px solid black;
                                        width: 25%;
                                        float: right;
                                }
                            </style>
                            
                        </div>
                            
                            
                            
            </div>
          </div>

        </section>
      </div>

      <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("admin/delete-order/") }}'+"/"+id)
        }

        (function($) {
            "use strict";
            $(document).ready(function() {

                $(".print_btn").on("click", function(){
                    $(".custom_click").click();
                    window.print()
                })

            });
        })(jQuery);
    </script>
@endsection
