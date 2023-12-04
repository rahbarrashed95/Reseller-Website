@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Products')}}</title>
@endsection
@section('admin-content')

        <style>
            .remove i {
                color: #ffffff;
            }
            .text-area-test {
                min-height: 60px !important;    
            }
        </style>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Edit Order</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Edit Product')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Products')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.pay_order') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                          <div class="row">
                          <div class="col-md-12">
                            <div class="row">
                              
                            <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label>Total Amount <span class="text-danger">*</span></label>
                                    <input type="text" id="payment_amount" class="form-control"  name="payment_amount" value="{{ $seller_payment_data->total_payable_earn }}">
                                    <input type="hidden" name="seller_id" value="{{ $seller_payment_data->seller_id }}">
                                    <input type="hidden" name="unique_key" value="{{ $seller_payment_data->unique_key }}">
                                </div>    
                            </div>
                            
                            <div class="col-md-4">
                               
                              <div class="form-group col-12">
                                    <label>Order ID</label>
                                    <textarea name="order_id" id="" cols="30" rows="10" class="form-control text-area-test">{{ implode(', ', array_unique(explode(',', $seller_payment_data->order_ids))) }}</textarea>
                                </div>                          
                             
                              </div>
                              
                              <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label>Payment Title <span class="text-danger">*</span></label>
                                    <input type="text" id="payment_title" class="form-control"  name="payment_title" value="">
                                </div>   
                              </div>
                             
                             <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label  class="form-label">Payment Number</label>
                                    <input type="text" class="form-control" id="payment_no" name="payment_no" value="" />
                                </div>                              
                             </div>
                             <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label  class="form-label">Payment ID</label>
                                    <input type="text" class="form-control" name="payment_id" value="" />
                                </div>                              
                             </div>
                             <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label  class="form-label">Payment Date</label>
                                    <input type="date" class="form-control" name="payment_date" value="" />
                                </div>                              
                             </div>
                         
                        </div>
                            </div>
                          </div>
                          </div>
                               
                                
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Update')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  
  $(document).ready(function() {
      
    calculateSum();
  });
  
  $(document).on('blur change',".quantity",function(e) {
        let current_stock=Number($(this).val());
        let stock = Number($(this).data('qty'));       
        
        if (current_stock>stock) {
            toastr.error('Product Stock Not Available');
            $(this).val(stock);
            calculateSum();
            return false;
        }
       
    });
  
    $(document).on('blur',".quantity, .unit_price",function(e) {    
     calculateSum();    
    });
  
    $(document).on('change',"#shipping_charge",function(e) {
        calculateSum();    
    });
    
    // $(document).on('change',"#shipping_rule",function(e) {
    //     calculateSum();    
    // });  
  
  
    function calculateSum() {
        var adv_amount = $('input[name="advance_amount"]').val();
        let tblrows = $("#product_table tbody tr");
        let sub_total= 0;
        let row_discount=0;
        // let shipping = $('#cost').val();
        let total_qty = 0;
        // let shipping=Number(tblrows.find('td input.shipping_cost').val());
        let shipping=Number($("#shipping_charge option:selected").data('charge'));        
        tblrows.each(function (index) {
            let tblrow = $(this);
            let qty=Number(tblrow.find('td input.quantity').val());
            let amount=Number(tblrow.find('td input.unit_price').val());
            let discount=Number(tblrow.find('td input.discount_price').val());
            let row_total = parseFloat(qty *amount);
            row_discount+=Number(qty *discount);
            sub_total +=row_total;
            tblrow.find('td.row_total').text(row_total.toFixed(2));    
            total_qty += qty;
        });
        
        sub_total+=shipping;
        
        sub_total = sub_total-adv_amount;
        
        $('input#total_amount').val(sub_total);
        $('input#total_qty').val(total_qty.toFixed(2));
        $('input#total_discount').val(row_discount.toFixed(2));
       // $('input#shipping_charge').val(charge.toFixed(2));
    }
  
    $(function(){
         $(document).on('change', 'select[name="courier_id"]', function(e){
    	let courier_id = $(this).val();
    	if(courier_id == 1)
        {
          	$(document).find('div.for_redx').removeClass('d-none');
          	$(document).find('div.for_pathao').addClass('d-none');
        }    	
    	
    	else if(courier_id == 2)
        {
          	$(document).find('div.for_pathao').removeClass('d-none');
          	$(document).find('div.for_redx').addClass('d-none');
        }
    
    	else {
            $(document).find('div.for_pathao').addClass('d-none');
          	$(document).find('div.for_redx').addClass('d-none');
        }
  });
  
  $(document).on('click',".remove",function(e) {
        var whichtr = $(this).closest("tr");
        whichtr.remove();  
        calculateSum();    
    });
  
  $(document).on('blur', 'input[name="advance_amount"]', function() {
      
      let adv_amount = $(this).val();
      let total_val = $('#total_amount').val();
      if(adv_amount != null || adv_amount != '') {
          var ultimate_amount = total_val - adv_amount;
      } else {
          ultimate_amount = total_val;
      }
      $('input#total_amount').val(ultimate_amount);
  });
  
  $(document).on('change', '#city_select', function(e){
    let city = $(this).val();
    var url = "{{ route('admin.zonesByCity', ":city") }}";
	url = url.replace(':city', city);
    $.ajax({
        url,
        type: 'GET',
        dataType: "json",
        success: function(res){
          if(res.success)
          {
            let html = "<option value=''>Select One</option>";
            for(let i = 0; i < res.zones.length; i++)
            {
               html += "<option value='"+res.zones[i].zone_id+"' >"+res.zones[i].zone_name+"</option>";
            }
            
            $('#zone_select').html(html);
            
          }
        }
      
    });
    
  });
  
   $(document).on('change', '#zone_select', function(e){
    let zone = $(this).val();
    var url = "{{ route('admin.areasByZone', ":zone") }}";
	url = url.replace(':zone', zone);
    $.ajax({
        url,
        type: 'GET',
        dataType: "json",
        success: function(res){
          if(res.success)
          {
            let html = "<option value=''>Select One</option>";
            for(let j = 0; j < res.areas.length; j++)
            {
               html += "<option value='"+res.areas[j].area_id+"' >"+res.areas[j].area_name+"</option>";
            }
            
            $('select[name="pathao_area_id"]').html(html);
            
          }
        }
      
    });
    
  });
  
//   $(document).ready(function() {
//     $('.select2').select2();
//   });

  $(document).on('change',"#area_select",function(e) {
    let area_id = $(this).val();
    
    let area_name = $("#area_select option:selected").text();
    $("#area_id").val(area_id);
    $("#area_name").val(area_name);
  });
  
  
    });
</script>
@endsection
