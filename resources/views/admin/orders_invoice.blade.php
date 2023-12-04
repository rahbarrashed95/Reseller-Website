@extends('admin.master_layout')
@section('title')
<title></title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('seller.dashboard') }}">{{__('admin.Dashboard') }}</a></div>
              <div class="breadcrumb-item"></div>
            </div>
          </div>

          <div class="section-body">
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
                                    <th width="15%">Paid Status</th>
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
                                     <td>
                                        @if($data->due_amount == '0')
                                        Paid
                                        @else
                                        Not Paid
                                        @endif
                                     </td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.order-invoice-show',[$data->seller_id,$data->unique_key]) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="{{ route('admin.order-payment',[$data->seller_id,$data->unique_key]) }}" class="btn btn-primary btn-sm"> <i class="fa fa-credit-card" aria-hidden="true"></i></a>
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

@endsection
