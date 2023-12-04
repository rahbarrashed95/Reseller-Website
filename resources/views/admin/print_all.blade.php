<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="ThemeMarch">
    <!-- Site Title -->
    <title>Soft It Global</title>
    <link rel="stylesheet" href="{{asset('invoice/assets/css/style.css')}}">
</head>

<body>
   @foreach($items as $item)
    <div class="cs-container">
        <div class="cs-invoice cs-style1">
            <div class="cs-invoice_in" id="download_section">
                <div class="cs-invoice_head cs-type1 cs-mb25">
                  Date: {{ $item->orderAddress->created_at }}
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <b class="cs-primary_color">Invoice / Recipt:</b>
                        <p>Invoice: {{$item->order_id}} <br> Customer: {{ $item->orderAddress->shipping_name }} 
                      	<br />{{ $item->orderAddress->shipping_address }} <br /> {{$item->orderAddress->shipping_phone}}
                      </p>
                      	
                    </div>
                    <div class="cs-invoice_right cs-text_right">
                      	 <div class="cs-invoice_right cs-text_right">
                        <div class="cs-logo cs-mb5"><img src="{{ asset($setting->logo) }}" alt="Logo" width="80px" height="40px"></div>
                    </div>
                        <b class="cs-primary_color">{{ $setting->site_name }}</b>
                        <p>
                             <br /> {{ $setting->contact_email }} 
                        </p>
                    </div>
                </div>
                
                <div class="cs-table cs-style2">
                    <div class="cs-round_border">
                        <div class="cs-table_responsive">
                            <table>
                                <thead>
                                    <tr class="cs-focus_bg">
                                        <th class="cs-width_6 cs-semi_bold cs-primary_color">Items Details</th>
                                      	<th class="cs-width_6 cs-semi_bold cs-primary_color">Color And Size</th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color">Price</th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color">QTY</th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color cs-text_right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                   @php
                            $subTotal = 0;
                        @endphp
                        @foreach ($item->orderProducts as $index => $orderProduct)
                            @php
                                $variantPrice = 0;
                                $totalVariant = $orderProduct->orderProductVariants->count();
                            @endphp
                                    <tr>
                                        <td class="cs-width_6">
                                           {{ $orderProduct->product_name }}
                                        </td>
                                      	<td class="cs-width_6">
                                             {{ $orderProduct->variation_color_id }} /
                                  			 {{ $orderProduct->variation }}	
                                        </td>
                                        <td class="cs-width_2">{{ $setting->currency_icon }}{{ $orderProduct->unit_price }}</td>
                                        <td class="cs-width_2">{{ $orderProduct->qty }}</td>
                                      	  @php
                                    $total = ($orderProduct->unit_price * $orderProduct->qty)
                                @endphp
                                        <td class="cs-width_2 cs-text_right cs-primary_color">{{ $setting->currency_icon }}{{ $total }}</td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="cs-invoice_footer">
                        <div class="cs-left_footer cs-mobile_hide"></div>
                        <div class="cs-right_footer">
                            <table>
                                <tbody>
                                   @php
                                        $sub_total = $item->total_amount;
                                        $sub_total = $sub_total - $item->shipping_cost;
                                        $sub_total = $sub_total + $item->coupon_coast;

                                    @endphp
                                    <tr class="cs-border_none">
                                        
                                     </tr>
									<tr>	                                  
                                        <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color cs-text_right">Sub Total : {{ $setting->currency_icon }}{{ round($sub_total, 2) }}</td> <br />
                                  </tr>
                                  <tr>
                                      <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color cs-text_right">Discount : {{ $setting->currency_icon }}{{ round($item->coupon_coast, 2) }}</td> <br />  
                                  </tr>
                                  <tr>
                                    <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color cs-text_right">Shipping :{{ $setting->currency_icon }}{{ round($item->shipping_cost, 2) }}</td>
                                      	
                                    </tr>
                                  
                                  <tr>
                                    <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color cs-text_right">In Total :{{ round($item->total_amount, 2) }}</td>
                                      	
                                    </tr>
                                  @endforeach  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="cs-note">
                    <div class="cs-note_left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path
                d="M416 221.25V416a48 48 0 01-48 48H144a48 48 0 01-48-48V96a48 48 0 0148-48h98.75a32 32 0 0122.62 9.37l141.26 141.26a32 32 0 019.37 22.62z"
                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <path d="M256 56v120a32 32 0 0032 32h120M176 288h160M176 368h160" fill="none" stroke="currentColor"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
            </svg>
                    </div>
                    <div class="cs-note_right">
                        <p class="cs-mb0"><b class="cs-primary_color cs-bold">Note:</b></p>
                        <p class="cs-m0">Here we can write a additional notes for the client to get a better understanding of this invoice.
                        </p>
                    </div>
                </div>
                <!-- .cs-note -->
            </div>
            <div class="cs-invoice_btns cs-hide_print">
                <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
            <path
              d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
              fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
            <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor"
              stroke-linejoin="round" stroke-width="32" />
            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
              stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
            <circle cx="392" cy="184" r="24" />
          </svg>
                    <span>Print</span>
                </a>
                <button id="download_btn" class="cs-invoice_btn cs-color2">
          <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
            <title>Download</title>
            <path d="M336 176h40a40 40 0 0140 40v208a40 40 0 01-40 40H136a40 40 0 01-40-40V216a40 40 0 0140-40h40"
              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
              d="M176 272l80 80 80-80M256 48v288" />
          </svg>
          <span>Download</span>
        </button>
            </div>
        </div>
    </div>
  	@endforeach
  	
    <script src="{{asset('invoice/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('invoice/assets/js/jspdf.min.js')}}"></script>
    <script src="{{asset('invoice/assets/js/html2canvas.min.js')}}"></script>
    <script src="{{asset('invoice/assets/js/main.js')}}"></script>
</body>

</html>