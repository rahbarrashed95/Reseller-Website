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
                                    <th width="5%">{{__('admin.SN')}}</th>
                                    <th width="10%">Order Id</th>
                                    <th width="10%">Date</th>
                                    <th width="15%">Product Price</th>
                                    <th width="15%">Seller Sell Price</th>
                                    <th width="15%">Earning</th>
                                    <th width="10%">Advance Amount</th>
                                    <th width="10%">Shipping Cost</th>
                                    <th width="5%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @php $sub_total_earn = 0; $sub_total_price = 0; $sub_total_sell_price = 0; $total_advance = 0; $total_shipping = 0; @endphp
                                @foreach ($seller_earn_data as $index => $earn)
                                   @php
                                    $sub_total_earn  = $sub_total_earn + $earn->total_earn;
                                    $sub_total_price = $sub_total_price + $earn->total_price;
                                    $sub_total_sell_price = $sub_total_sell_price + $earn->total_sell_price;
                                    $total_advance = $total_advance + $earn->advance_amount;
                                    $total_shipping = $total_shipping + $earn->shipping_cost;
                                    @endphp
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $earn->order_id }}</td>
                                        <td>{{ $earn->created_at->format('d F, Y') }}</td>
                                        <td>{{ $earn->total_price }}</td>
                                        <td>{{ $earn->total_sell_price }}</td>
                                        <td>{{ $earn->total_earn }}</td>
                                        <td>{{ $earn->advance_amount }}</td>
                                        <td>{{ $earn->shipping_cost }}</td>
                                        <td>
                                            <a href="{{ route('seller.seller_invoice',[$earn->order_id]) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                            <tbody>
                                <tr style="border-top: 1px solid #DDDDDD;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="font-weight: 900;">{{ $sub_total_price }}</td>
                                    <td style="font-weight: 900;">{{ $sub_total_sell_price }}</td>
                                    <td style="font-weight: 900;">{{ $sub_total_earn }}</td>
                                    <td style="font-weight: 900;">{{ $total_advance }}</td>
                                    <td style="font-weight: 900;">{{ $total_shipping }}</td>
                                </tr>
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
