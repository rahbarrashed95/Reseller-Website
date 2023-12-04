@include('admin.header')

<style>
    .auth-section-wrapper {
        align-items: normal;
        margin-top: 50px !important;
    }
    .auth-section-wrapper .form-area-wrapper {
        align-items: baseline;
    }
    .auth-section-wrapper {
        gap: 0px !important;
    }
    .auth-section-wrapper .card-wrapper-auth {
        margin: 0px 0px !important;
    }
    .logo {
        margin-bottom: 20px;
    }
    .logo img {
        width: 200px;
    }
</style>

<div id="app">
    <section class="section">
        <div class="auth-section-wrapper">
            
            <div class="form-area-wrapper">
                <div class="col-md-8 offset-md-2 form-content-wrapperaaaa">
                    <div class="logo">
                        <img src="{{ asset($setting->logo) }}" alt="logo"/>
                    </div>
                    <div class="card card-primary card-wrapper-auth">
                        <div class="card-body">
                            <form class="needs-validation" novalidate="" id="adminLoginForm">
                                @csrf

                                <div>
                                <h3>Seller Information</h3>
                                <p>Fill the form below or write us We will help you as soon as possible</p>
                                
                                </div>    
                                <hr/>
                                <div class="form-group">
                                    <label for="name">{{__('admin.Name')}}<sup>*</sup></label>
                                    <input id="name" type="text" class="form-control" name="name" tabindex="1" value="{{ old('name') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">{{__('admin.Phone')}}<sup>*</sup></label>
                                    <input id="phone" type="text" class="form-control" name="phone" tabindex="1" value="{{ old('phone') }}">
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="email">{{__('admin.Email')}}<sup>*</sup></label>
                                    <input id="email exampleInputEmail" type="email" class="form-control" name="email" tabindex="1" value="{{ old('email') }}">
                                </div>
                                
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" id="psw" placeholder="Enter Password (Minimum 8 Charactar)" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">{{__('admin.Password')}}<sup>*</sup></label>
                                    </div>
                                    <input id="password exampleInputPassword" type="password" name="password_confirmation" class="form-control" id="psw" placeholder="Enter confirm-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                    
                                </div>

                                <!--<div class="form-group">-->
                                <!--    <div class="custom-control custom-checkbox">-->
                                <!--        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>-->
                                <!--        <label class="custom-control-label" for="remember">{{__('admin.Remember Me')}}</label>-->
                                <!--    </div>-->
                                <!--</div>-->
                                
                                <div>
                                <h3>Shop Information</h3>
                                <p>Fill the form below or write us We will help you as soon as possible</p>
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <label for="shop_name">{{__('Shop Name')}}</label>
                                    <input id="shop_name" type="text" class="form-control" name="shop_name" tabindex="1" autofocus value="{{ old('shop_name') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="address">{{__('Shop Address')}}</label>
                                    <input id="address" type="text" class="form-control" name="address" tabindex="1" autofocus value="{{ old('address') }}">
                                </div>

                                <div class="form-group">
                                    <button id="adminLoginBtn" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        {{__('Register')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="simple-footer">
                        {{ $setting->copyright }}
                    </div>
                </div>
            </div>
            <div class="simple-footer">
                {{ $setting->copyright }}
            </div>
        </div>
    </section>
 </div>


<script>
    (function($) {
    "use strict";
    $(document).ready(function () {
        $("#adminLoginBtn").on('click',function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('seller.register') }}",
                type:"post",
                data:$('#adminLoginForm').serialize(),
                success:function(response){
                    if(response.success){
                        window.location.href = "{{ route('seller.dashboard')}}";
                        toastr.success(response.success)
                    }
                    if(response.error){
                        toastr.error(response.error)
                    }
                },
                error:function(response){
                    console.log(response);
                    if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                    if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])
                    if(response.responseJSON.errors.phone)toastr.error(response.responseJSON.errors.phone[0])
                }

            });


        })
        
    });

    })(jQuery);
</script>

@include('admin.footer')


