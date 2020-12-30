@extends('web._layouts.main')

@section('content')
<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    @include('system._components.notifications')
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Profile Form</h4>
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <hr class="form pt-0">
                            <div class="card-body registration-card">
                                <h5 class="text-title text-uppercase ">Account Information</h5>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">First Name</label>
                                            <input type="text" class="form-control {{ $errors->first('fname') ? 'is-invalid': NULL  }} form-control-sm" name="fname" placeholder="Firstname" value="{{old('fname', $account->fname)}}">
                                             @if($errors->first('fname'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('fname')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group mb-0">
                                            <label class="text-form pb-2">Last Name</label>
                                            <input type="text" class="form-control {{ $errors->first('lname') ? 'is-invalid': NULL  }} form-control-sm" name="lname" placeholder="Lastname" value="{{old('lname', $account->lname)}}">
                                            @if($errors->first('lname'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('lname')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group ">
                                            <label class="text-form pb-2">Middle Name</label>
                                            <input type="text" class="form-control form-control-sm" name="mname" placeholder="Middlename" value="{{old('mname', $account->mname)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">Contact Number</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                                </div>
                                                <input type="text" class="form-control {{$errors->first('contact_number') ? 'is-invalid' : NULL}}" id="input_contact_number" name="contact_number" placeholder="" value="{{old('contact_number',$account->contact_number)}}" data-inputmask-alias="9999999999">
                                                @if($errors->first('contact_number'))
                                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('contact_number')}}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">Email Address</label>
                                            <input type="email" class="form-control {{$errors->first('email') ? 'is-invalid' : NULL}}" id="input_contact_number" name="email" placeholder="" value="{{old('email',$account->email)}}">
                                            @if($errors->first('email'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('email')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="text-form pb-2 {{ $errors->first('gender') ? 'is-invalid': NULL  }} ">Gender</label>
                                            {!! Form::select('gender', ['male' => 'Male', 'female' => 'Female'], old('gender', $account->gender),['id' => "input_gender",'class' => "form-control form-control-sm classic ".($errors->first('gender') ? 'border-red' : NULL)])!!}
                                            @if($errors->first('gender'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('gender')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="region_name" id="input_region_name" value="{{old('region_name', $account->region_name)}}">
                                <input type="hidden" class="form-control" name="town_name" id="input_town_name" value="{{old('town_name', $account->town_name)}}">
                                <input type="hidden" class="form-control" name="brgy_name" id="input_brgy_name" value="{{old('brgy_name', $account->barangay_name)}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">Region</label>
                                            {!!Form::select('region',[],old('region'),['id' => "input_region",'class' => "form-control form-control-sm classic ".($errors->first('region') ? 'border-red' : NULL)])!!}
                                            @if($errors->first('region'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('region')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">City Municipality</label>
                                            {!!Form::select('town',[],old('town'),['id' => "input_town",'class' => "form-control form-control-sm classic ".($errors->first('city') ? 'border-red' : NULL)])!!}
                                            @if($errors->first('town'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('town')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">Barangay</label>
                                            {!!Form::select('brgy',[],old('brgy'),['id' => "input_brgy",'class' => "form-control form-control-sm classic ".($errors->first('brgy') ? 'border-red' : NULL)])!!}
                                            @if($errors->first('brgy'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('brgy')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">Street Name</label>
                                            <input type="text" class="form-control {{ $errors->first('street_name') ? 'is-invalid': NULL  }} form-control-sm" name="street_name" placeholder="Street Name" value="{{old('street_name', $account->street_name)}}">
                                             @if($errors->first('street_name'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('street_name')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">BLDG/ Unit Number</label>
                                            <input type="text" class="form-control {{ $errors->first('unit_number') ? 'is-invalid': NULL  }} form-control-sm" name="unit_number" placeholder="Unit Number" value="{{old('unit_number', $account->unit_number)}}">
                                            @if($errors->first('unit_number'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('unit_number')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                            <input type="text" id="input_zipcode" class="form-control {{ $errors->first('zipcode') ? 'is-invalid': NULL  }}" name="zipcode" value="{{old('zipcode', $account->zipcode)}}" readonly="readonly">
                                            @if($errors->first('zipcode'))
                                            <p class="help-block text-danger">{{$errors->first('zipcode')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">Birthdate</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control datepicker {{ $errors->first('birthdate') ? 'is-invalid': NULL  }} br-right-white p-2" name="birthdate" placeholder="YYYY-MM-DD" value="{{old('birthdate', $account->birthdate)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text text-title fw-600"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            @if($errors->first('birthdate'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('birthdate')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h5 class="text-title text-uppercase ">Account Requirements</h5>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">TIN No.</label>
                                            <input type="text" class="form-control {{ $errors->first('tin_no') ? 'is-invalid': NULL  }} form-control-sm" name="tin_no" placeholder="TIN No." value="{{old('tin_no', $account->tin_no)}}">
                                            @if($errors->first('tin_no'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('tin_no')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">SSS No.</label>
                                            <input type="text" class="form-control {{ $errors->first('sss_no') ? 'is-invalid': NULL  }} form-control-sm" name="sss_no" placeholder="SSS No." value="{{old('sss_no', $account->sss_no)}}">
                                            @if($errors->first('sss_no'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('sss_no')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="text-form pb-2">PHIC No.</label>
                                            <input type="text" class="form-control {{ $errors->first('phic_no') ? 'is-invalid': NULL  }} form-control-sm" name="phic_no" placeholder="PHIC No." value="{{old('phic_no', $account->phic_no)}}">
                                            @if($errors->first('phic_no'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('phic_no')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn secondary-solid-btn px-3 py-3 fs-14 otp_trigger"><i class="fa fa-paper-plane pr-2"></i>Update Account</button>
                            </div>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!--team section end-->


@stop

@section('page-styles')
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<style type="text/css">
    .underline {
        border-bottom: solid 1px;
    }
</style>
@endsection
@section('page-scripts')
<script src="{{asset('system/vendors/inputmask/jquery.inputmask.bundle.js')}}"></script>
<script src="{{asset('system/js/inputmask.js')}}"></script>
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
    $('#file').change(function(e){
      var fileName = e.target.files[0].name;
      $('#lblName').text(fileName);
    });
    $.fn.get_region = function(input_region,input_province,input_city,input_brgy,selected){

      $(input_city).empty().prop('disabled',true)
      $(input_brgy).empty().prop('disabled',true)

      $(input_region).append($('<option>', {
                value: "",
                text: "Loading Content..."
            }));
      $.getJSON("{{env('PSGC_REGION_URL')}}", function( response ) {
          $(input_region).empty().prop('disabled',true)
          $.each(response.data,function(index,value){
            $(input_region).append($('<option>', {
                value: index,
                text: value
            }));
          })

          $(input_region).prop('disabled',true)
          $(input_region).prepend($('<option>',{value : "",text : "--Select Region--"}))
            if(selected.length > 0){
                $(input_region).val($(input_region+" option[value="+selected+"]").val());
            }else{
                $(input_region).val($(input_region+" option:first").val());
            }

      });
      // return result;
    };

    $.fn.get_city = function(reg_code,input_city,input_brgy,selected){
      $(input_brgy).empty().prop('disabled',true)
      $(input_city).append($('<option>', {
            value: "",
            text: "Loading Content..."
        }));
      $.getJSON("{{env('PSGC_CITY_URL')}}?region_code="+reg_code, function( data ) {
        console.log(data)
          $(input_city).empty().prop('disabled',true)
          $.each(data,function(index,value){
              $(input_city).append($('<option>', {
                  value: index,
                  text: value
              }));
          })

          $(input_city).prop('disabled',true)
          $(input_city).prepend($('<option>',{value : "",text : "--SELECT MUNICIPALITY/CITY, PROVINCE--"}))
          if(selected.length > 0){
            $(input_city).val($(input_city+" option[value="+selected+"]").val());
          }else{
            $(input_city).val($(input_city+" option:first").val());
          }
      });
      // return result;
    };

    $.fn.get_brgy = function(munc_code,input_brgy,selected){
      $(input_brgy).empty().prop('disabled',true);
      $(input_brgy).append($('<option>', {
                value: "",
                text: "Loading Content..."
            }));
      $.getJSON("{{env('PSGC_BRGY_URL')}}?city_code="+munc_code, function( data ) {
          $(input_brgy).empty().prop('disabled',true);

          $.each(data,function(index,value){
            $(input_brgy).append($('<option>', {
                value: index,
                text: value.desc,
                "data-zip_code" : (value.zip_code).trim()
            }));
          })
          $(input_brgy).prop('disabled',false)
          $(input_brgy).prepend($('<option>',{value : "",text : "--SELECT BARANGAY--"}))

          if(selected.length > 0){
            $(input_brgy).val($(input_brgy+" option[value="+selected+"]").val());

            if(typeof $(input_brgy+" option[value="+selected+"]").data('zip_code')  === undefined){
              $(input_brgy.replace("brgy","zipcode")).val("")
            }else{
              $(input_brgy.replace("brgy","zipcode")).val($(input_brgy+" option[value="+selected+"]").data('zip_code'))
            }

          }else{
            $(input_brgy).val($(input_brgy+" option:first").val());
          }
      });
    }
    $(function(){
        load_barangay();
        $('.datepicker').datepicker({
          format : "yyyy-mm-dd",
          maxViewMode : 2,
          autoclose : true,
          zIndexOffset: 9999
        });

        $(this).get_region("#input_region","#input_province","#input_town","#input_brgy", "{{old('region',$account->region)}}")
        $(this).get_city("{{ $account->region }}", "#input_town", "#input_brgy", "{{old('town', $account->town)}}");
        $(this).get_brgy("{{ $account->town }}", "#input_brgy", "{{ $account->barangay }}");

        $("#input_region").on("change", function(){
            var _val = $(this).val();
            var _text = $("#input_region option:selected").text();
            $(this).get_city($("#input_region").val(), "#input_town", "#input_brgy", "{{old('town')}}");
            $('#input_zipcode').val('');
            $('#input_region_name').val(_text);
        });
        function load_barangay() {
            var _val = "097332000";
            var _text = "ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA";
            $(this).get_brgy(_val, "#input_brgy", "");
            $('#input_zipcode').val('');
            $('#input_town_name').val(_text);
        }

        $("#input_town").on("change",function(){
            var _val = $(this).val();
            var _text = $("#input_town option:selected").text();
            $(this).get_brgy('097332000', "#input_brgy", "");
            $('#input_zipcode').val(_val);
            $('#input_town_name').val(_text);
        });

        @if(strlen(old('region')) > 0)
            $(this).get_city("{{old('region')}}", "#input_town", "#input_brgy", "{{old('town')}}");
        @endif

        @if(strlen(old('town')) > 0)
            $(this).get_brgy("{{old('town')}}", "#input_brgy", "{{old('brgy')}}");
        @endif

        $("#input_brgy").on("change",function(){
            $('#input_zipcode').val($(this).find(':selected').data('zip_code'))
            var _text = $("#input_brgy option:selected").text();
            $('#input_brgy_name').val(_text);
        });

    })
    $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
    });
</script>
@endsection
