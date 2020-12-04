@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="create-form" method="POST" enctype="multipart/form-data">
                    @include('system._components.notifications')
                    {!!csrf_field()!!}
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $business->business_name }} Business Information Form</h3>
                        </div>
                        <div class="card-body">
                            <h5 class="text-title text-uppercase">Business Information</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Scope</label>
                                        <h4 class="form-data text-success">{{ Str::upper($business->business_scope) }}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Type</label>
                                        <h4 class="form-data text-success">{{ Str::upper($business->business_type) }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Dominant Name</label>
                                        <h4 class="form-data text-success">{{ Str::upper($business->dominant_name) }}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Name</label>
                                        <h4 class="form-data text-success">{{ Str::upper($business->business_name) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group {{$errors->first('no_male_employee') ? 'text-danger' : NULL}}">
										<label for="input_no_male_employee" class="text-form pb-2">Total No. of Male Employees</label>
										<input type="number" id="input_no_male_employee" class="form-control" name="no_male_employee" value="{{old('no_male_employee', $business->no_of_male_employee)}}">
										@if($errors->first('no_male_employee'))
										<p class="help-block text-danger">{{$errors->first('no_male_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group {{$errors->first('male_residing_in_city') ? 'text-danger' : NULL}}">
										<label for="input_male_residing_in_city" class="text-form pb-2">No. of Male Employees Residing In City</label>
										<input type="number" id="input_male_residing_in_city" class="form-control" name="male_residing_in_city" value="{{old('male_residing_in_city', $business->male_residing_in_city)}}">
										@if($errors->first('male_residing_in_city'))
										<p class="help-block text-danger">{{$errors->first('male_residing_in_city')}}</p>
										@endif
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group {{$errors->first('no_female_employee') ? 'text-danger' : NULL}}">
										<label for="input_no_female_employee" class="text-form pb-2">Total No. of Female Employees</label>
										<input type="number" id="input_no_female_employee" class="form-control" name="no_female_employee" value="{{old('no_female_employee', $business->no_of_female_employee)}}">
										@if($errors->first('no_female_employee'))
										<p class="help-block text-danger">{{$errors->first('no_female_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group {{$errors->first('female_residing_in_city') ? 'text-danger' : NULL}}">
										<label for="input_female_residing_in_city" class="text-form pb-2">No. of Female Employees Residing In City</label>
										<input type="number" id="input_female_residing_in_city" class="form-control" name="female_residing_in_city" value="{{old('female_residing_in_city', $business->female_residing_in_city)}}">
										@if($errors->first('female_residing_in_city'))
										<p class="help-block text-danger">{{$errors->first('female_residing_in_city')}}</p>
										@endif
									</div>
								</div>
							</div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Line of Business</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('business_line') ? 'is-invalid': NULL  }}"  name="business_line" value="{{old('business_line', $business->business_line) }}">
                                        @if($errors->first('business_line'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_line')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Capitalization</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('capitalization') ? 'is-invalid': NULL  }}"  name="capitalization" value="{{old('capitalization', $business->capitalization) }}">
                                        @if($errors->first('capitalization'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('capitalization')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('email') ? 'is-invalid': NULL  }}"  name="email" value="{{old('email',$business->email) }}">
                                        @if($errors->first('email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('email')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Website (URL)</label>
                                        <input type="url" class="form-control form-control-sm {{ $errors->first('website_url') ? 'is-invalid': NULL  }}"  name="website_url" value="{{old('website_url', $business->website_url) }}">
                                        @if($errors->first('website_url'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('website_url')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('mobile_no') ? 'is-invalid': NULL  }}"  name="mobile_no" value="{{old('mobile_no',$business->mobile_no) }}">
                                        @if($errors->first('mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('telephone_no') ? 'is-invalid': NULL  }}"  name="telephone_no" value="{{old('telephone_no',$business->telephone_no) }}">
                                        @if($errors->first('telephone_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('telephone_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-title text-uppercase">Other Information Form (Government Owned Or Controlled Corporations)</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">TIN No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('tin_no') ? 'is-invalid': NULL  }}"  name="tin_no" value="{{old('tin_no', $business->tin_no) }}">
                                        @if($errors->first('tin_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('tin_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">SSS No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('sss_no') ? 'is-invalid': NULL  }}"  name="sss_no" value="{{old('sss_no', $business->sss_no) }}">
                                        @if($errors->first('sss_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('sss_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Philhealth No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('philhealth_no') ? 'is-invalid': NULL  }}"  name="philhealth_no" value="{{old('philhealth_no', $business->philhealth_no) }}">
                                        @if($errors->first('philhealth_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('philhealth_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">PAGIBIG No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('pagibig_no') ? 'is-invalid': NULL  }}"  name="pagibig_no" value="{{old('pagibig_no', $business->pagibig_no) }}">
                                        @if($errors->first('pagibig_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('pagibig_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <a href="{{route('web.business.index')}}" class="btn btn-light" style="float: right;">Cancel</a>
                            <button type="submit" class="btn badge-primary-2 text-white mr-2" style="float: right;">Create Record</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

</section>
<!--team section end-->


@stop

@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
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

          $(input_region).prop('disabled',false)
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

          $(input_city).prop('disabled',false)
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

        $(this).get_region("#input_region","#input_province","#input_town","#input_brgy","{{old('region')}}")

        $("#input_region").on("change",function(){
            var _val = $(this).val();
            var _text = $("#input_region option:selected").text();
            $(this).get_city($("#input_region").val(), "#input_town", "#input_brgy", "{{old('town')}}");
            $('#input_zipcode').val('');
            $('#input_region_name').val(_text);
        });

        $("#input_town").on("change",function(){
            var _val = $(this).val();
            var _text = $("#input_town option:selected").text();
            $(this).get_brgy(_val, "#input_brgy", "");
            $('#input_zipcode').val('');
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
</script>
@endsection
