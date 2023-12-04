@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Invoice')}}</title>
@endsection

@php

use App\Models\Information;

$info = Information::first();

@endphp

<style>
    .invoice {
        padding: 80px !important;
    }

    @media print {

        .section-header,
        #sidebar-wrapper,
        #product_table {
            display: block;
        },
        .print-area,
        .main-footer,
        .barcode,
        .additional_info {
            display:none!important;
        }
        .status_section {
            display:none!important;
        }

        .section-body-2 {
            display: none !important;
        }

        }
</style>
@section('admin-content')
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
                <div class="col-md-12 text-md-right print-area">
                    <button class="btn btn-success btn-icon icon-left print_btn"><i class="fas fa-print"></i> {{__('admin.Print')}}</button>
                </div>
            <div class="invoice-print">
                <div class="row">
                        <div class="col-md-6 img_section">
                            <h2 class="invoice-title"><img src="{{ asset($setting->logo) }}" alt="" width="200px"></h2>
                        </div>
                </div>

                <style>
                    .site_info {
                        border: 1px solid lightgray;
                        padding: 20px;
                    }
                    .reseller_info {
                        border: 1px solid lightgray;
                        padding: 20px;
                    }
                    address {
                        line-height: 1.5rem !important;
                    }
                </style>

                    <div class="row" style="">

                      <div class="col-md-5 col-sm-5 site_info" style="">
                        <address>
                          <strong>{{__('Shop Information')}} :</strong><br>
                          {{ $info->site_name }}<br/>
                          {{ $info->owner_email }} <br/>
                          {{ $info->owner_phone }}
                        </address>
                      </div>
                      <div class="col-md-2 col-sm-2">

                      </div>
                      <div class="col-md-5 col-sm-5 reseller_info" style="">
                        <address>
                          <strong>{{__('Seller Information')}} :</strong><br>
                          {{ $seller_info->shop_name }}<br/>
                          {{ $seller_info->address }} <br/>
                          {{ $user_info->phone }}

                        </address>
                      </div>
                    </div>

              </div>

              <div class="row mt-3 print-area">
                            <table class="table table-centered table-nowrap mb-0" id="product_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Total Wholesell Price</th>
                                        <th>Today Resell</th>
                                        <th>Delivery Charge</th>
                                        <th>Payable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @php $total_payable = 0; $total_paid_amount = 0;  @endphp
                                    @foreach($seller_invoice_data_first as $sid)
                                    @php
                                    $total_payable += $sid->payable;
                                    $total_paid_amount += $sid->paid;
                                    @endphp
                                        <tr>
                                            <td>{{ $sid->id }}</td>
                                            <td>{{ $sid->name }}</td>
                                            <td>{{ $sid->phone }}</td>
                                            <td>{{ $sid->total_wholesell }}</td>
                                            <td>{{ $sid->total_resell }}</td>
                                            <td>{{ $sid->shipping }}</td>
                                            @if($sid->payable != '0')
                                            <td>{{ $sid->payable }}</td>
                                            @else
                                            <td>{{ $sid->paid }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                 </tbody>
                                 <tbody>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>Sub Total : </td>
                                         <td>{{ $total_payable }}</td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>Return Charge : </td>
                                         <td>0</td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                         <td class="barcode">

                                            <?php
                                            $barcodeValue = $unique_key; // Replace 'your_variable_here' with the actual value you want to use
                                            echo DNS1D::getBarcodeHTML($barcodeValue, 'C39');
                                            ?>

                                         </td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>Total Paid : </td>
                                         <td>{{ $total_paid }}</td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>Due : </td>
                                         @if($total_payable != '0')
                                         <td>{{ ($due == '0' ? $total_payable - $total_paid : $due ) }}</td>
                                         @else
                                         <td>{{ ($due == '0' ? $total_paid_amount - $total_paid : $due ) }}</td>
                                         @endif
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


        <div class="section-body-2">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>

                                    <th width="10%">ID</th>
                                    <th width="10%">Address</th>
                                    <th width="10%">Note</th>
                                    <th width="15%">Total</th>
                                    <th width="10%">Created At</th>
                                    <th width="5%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>

                                @foreach($seller_invoice_data as $data)
                                <tr>
                                    <td style="color: red;"> {{ $data->unique_key }}</td>
                                    <td>
                                    {{ $data->phone }}
                                    <br/>
                                    {{ $data->shop_name }}
                                    </td>
                                    <td style="color: red;">
                                        @php
                                            $orderIds = explode(',', $data->order_ids);
                                            echo implode(', ', $orderIds);
                                        @endphp
                                    </td>
                                     <td style="color: red;">{{ $data->total_amount }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.order-invoice-show',[$data->seller_id,$data->unique_key]) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>


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
