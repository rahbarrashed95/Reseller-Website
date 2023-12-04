@extends('seller.master_layout')
@section('title')
<title></title>
@endsection
@section('seller-content')
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
                                    <th width="15%">Paid</th>
                                    <th width="15%">Payable Earned</th>
                                    <th width="15%">Earning</th>
                                    <th width="10%">Advance Amount</th>
                                    <th width="10%">Shipping Cost</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @php $sub_total_earn = 0; $sub_total_payable_earn = 0; $sub_total_price = 0; $sub_total_sell_price = 0; $total_advance = 0; $total_shipping = 0; $total_paid = 0; @endphp
                                @foreach ($seller_earn_data as $index => $earn)
                                   @php
                                    $total_paid = $total_paid + $earn->paid;
                                    $sub_total_payable_earn  = $sub_total_payable_earn + $earn->total_payable_earn;
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
                                        <td>{{ $earn->paid }}</td>
                                        <td>{{ $earn->total_payable_earn }}</td>
                                        <td>{{ $earn->total_earn }}</td>
                                        <td>{{ $earn->advance_amount }}</td>
                                        <td>{{ $earn->shipping_cost }}</td>
                                        <td>
                                            @if ($earn->order_status == 1)
                                            <span class="badge badge-success">Process</span>
                                            @elseif ($earn->order_status == 2)
                                            <span class="badge badge-success">Courier</span>
                                            @elseif ($earn->order_status == 3)
                                            <span class="badge badge-success">Completed</span>
                                            @elseif ($earn->order_status == 4)
                                            <span class="badge badge-danger">Cancell</span>
                                            @elseif($earn->order_status == 5)
                                            <span class="badge badge-danger">On Hold</span>
                                            @elseif($earn->order_status == 6)
                                            <span class="badge badge-danger">Return</span>
                                            @elseif($earn->order_status == 7)
                                            <span class="badge badge-danger">Invoiced</span>
                                            @elseif($earn->order_status == 8)
                                            <span class="badge badge-danger">Partial</span>
                                            @else
                                            <span class="badge badge-danger">{{__('admin.Pending')}}</span>
                                            @endif
                                        </td>
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
                                    <td style="font-weight: 900;">{{ $total_paid }}</td>
                                    <td style="font-weight: 900;">{{ $sub_total_payable_earn }}</td>
                                    <td style="font-weight: 900;">{{ $sub_total_earn }}</td>
                                    <td style="font-weight: 900;">{{ $total_advance }}</td>
                                    <td style="font-weight: 900;">{{ $total_shipping }}</td>
                                    <td></td>
                                    <td></td>
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
