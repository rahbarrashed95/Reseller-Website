@extends('admin.master_layout')
@section('title')
<title>{{ $title }}</title>
@endsection
<style>

  .sortingid{
  	width: 0px !important;
  }
  .sortingAc{
  	width : 50px !important;
  }
</style>

@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{ $title }}</div>
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
                                    <th width="10%">Seller Id</th>
                                    <th width="10%">Payment Complete</th>
                                    <th width="15%">Earning</th>
                                    <th width="15%">Complete Delivery</th>
                                    <th width="15%">Pending Earning</th>
                                    <th width="15%">Pending Delivery</th>
                                    <th width="5%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach($seller_earn_data as $index => $data)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td> <a href="{{ route('admin.earns',[$data->id]) }}"> {{ $data->name }} </a> </td>
                                        <td>{{ $data->total_complete_payment }}</td>
                                        <td>{{ $data->total_earning }}</td>
                                        <td>{{ $data->total_pending_payment }}</td>
                                        <td>{{ $data->total_pending_earning }}</td>
                                        <td>{{ $data->total_pending_delivery }}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
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
     



<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/delete-order/") }}'+"/"+id)
    }
    $(document).ready(function(){

  $("select[name='redx_status']").on('change', function(){
      getOrderList();
  });

  $("select[name='courier_type']").on('change', function(){
      getOrderList();
  });

  $('.order_sts').on('click', function(){
      getOrderList();
  });




    $(".check_all").on('change',function(){
      $(".order_checkbox").prop('checked',$(this).is(":checked"));
    });

    $(document).on('submit', 'form#order_status_update_form', function(e){

        e.preventDefault();
        var url = $(this).attr('action');
        var method = $(this).attr('method');
        let status=$(document).find('select#multi_status').val();

        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();

        if(order_ids.length ==0){
            toastr.error('Please Select An Order First !');
            return ;
        }

        $.ajax({
    type: 'POST', // Change the request method to POST
    url: url,
    data: {
        status: status,
        order_ids: order_ids,
        _token: '{{ csrf_token() }}' // Include the CSRF token
    },
    success: function (res) {
        if (res.status == true) {
            toastr.success(res.msg);
            window.location.reload();
        } else if (res.status == false) {
            toastr.error(res.msg);
        }
    },
});



    });

    $(document).on('submit', 'form#order_assign_form', function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var method = $(this).attr('method');
        let assign_user_id=$(document).find('select#assign_user_id').val();

        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();

        if(order_ids.length ==0){
            toastr.error('Please Select An Order First !');
            return ;
        }

        $.ajax({
           type:'GET',
           url:url,
           data:{assign_user_id,order_ids},
           success:function(res){
               if(res.status==true){
                toastr.success(res.msg);
                window.location.reload();

            }else if(res.status==false){
                toastr.error(res.msg);
            }
           }
        });

    });

    $(document).on('click', 'a.multi_order_delete', function(e){
        e.preventDefault();
        var url = $(this).attr('href');

        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();

        if(order_ids.length ==0){
            toastr.error('Please Select An Order First !');
            return ;
        }

        $.ajax({
           type:'GET',
           url:url,
           data:{order_ids},
           success:function(res){
               if(res.status==true){
                toastr.success(res.msg);
                window.location.reload();

            }else if(res.status==false){
                toastr.error(res.msg);
            }
           }
        });

    });

    $(document).on('click', 'a.multi_order_print', function(e){
        e.preventDefault();
        var url = $(this).attr('href');

        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();

        if(order_ids.length ==0){
            toastr.error('Please Select Atleast One Order!');
            return ;
        }

        $.ajax({
           type:'GET',
           url,
           data:{order_ids},
           success:function(res){
               if(res.status==true){
                   console.log(res.items, res.info);
                   var myWindow = window.open("", "_blank");
  				   myWindow.document.write(res.view);
                // toastr.success(res.msg);
                // window.location.reload();

            }else if(res.status==false){
                toastr.error(res.msg);
            }
           }
        });

    });


  //Redx Courier Service
  $(document).on('click', 'a.send_to_redx', function(e){
        e.preventDefault();
    	var statusValue = $("input[name='status']:checked").val();
        var url = $(this).attr('href');
    	let link = $(this);
        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();

        if(order_ids.length ==0){
            toastr.error('Please Select Atleast One Order!');
            return ;
        }

        // else if(statusValue != '0'){
        //     toastr.error('Only On The Way Orders are Accepted!');
        //     return ;
        // }

        $.ajax({
           type:'GET',
           url,
           data:{order_ids},
           beforeSend: function(){
             link.addClass('disable-click');
             link.text('Please wait...');
           },
           success:function(res){
               link.removeClass('disable-click');
               link.text('Send to Redx');
               if(res.status){
                toastr.success(res.msg);

            }else{
                toastr.error(res.msg);
            }
           }
        });

    });

  //Pathao Courier Service
  $(document).on('click', 'a.send_to_pathao', function(e){
        e.preventDefault();
    	var statusValue = $("input[name='status']:checked").val();
        var url = $(this).attr('href');
    	let link = $(this);
        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();

        if(order_ids.length ==0){
            toastr.error('Please Select Atleast One Order!');
            return ;
        }

        // else if(statusValue != '0'){
        //     toastr.error('Only On The Way Orders are Accepted!');
        //     return ;
        // }


        $.ajax({
           type:'GET',
           url,
           data:{order_ids},
           beforeSend: function(){
             link.addClass('disable-click');
             link.text('Please wait...');
           },
           success:function(res){
               link.removeClass('disable-click');
               link.text('Send to Pathao');
               if(res.status){
                toastr.success(res.msg);

            }else{
                toastr.error(`Invoice :${res.invoice} something went wrong!`);
              	console.log(res.errors);
            }
           }
        });

    });

  //Steadfast Courier Service
  $(document).on('click', 'a.send_to_steadfast', function(e){
        e.preventDefault();
    	var statusValue = $("input[name='status']:checked").val();
        var url = $(this).attr('href');
    	let link = $(this);
        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();

        if(order_ids.length ==0){
            toastr.error('Please Select Atleast One Order!');
            return ;
        }

        // else if(statusValue != '0'){
        //     toastr.error('Only On The Way Orders are Accepted!');
        //     return ;
        // }


        $.ajax({
           type:'GET',
           url,
           data:{order_ids},
           beforeSend: function(){
             link.addClass('disable-click');
             link.text('Please wait...');
           },
           success:function(res){
               link.removeClass('disable-click');
               link.text('Send to Steadfast');
               if(res.status){
                toastr.success(res.msg);

            }else{
                toastr.error(`Invoice :${res.invoice} something went wrong!`);
              	console.log(res.errors);
            }
           }
        });
    });
})
</script>
@endsection
