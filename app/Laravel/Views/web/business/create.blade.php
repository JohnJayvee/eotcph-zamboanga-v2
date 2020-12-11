@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    @include('system._components.notifications')
                    <div class="card">
                        <div class="card-body">
                            <form meethod="get">
                                <h5 class="text-title text-uppercase">Business ID No.</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="text-form pb-2">Business ID No.</label>
                                            <input type="text" class="form-control form-control-sm {{ $errors->first('business_id_no') ? 'is-invalid': NULL  }}"  name="business_id_no" value="{{old('business_id_no') }}">
                                            @if($errors->first('business_id_no'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('business_id_no')}}</small>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn badge-primary-2 text-white mr-2" style="float: right;">Validate</button>
                                    </div>
                                </div>
                            </form>
                            <form class="create-form" method="POST"  action="{{ route('web.business.create') }}" enctype="multipart/form-data">
                            {!!csrf_field()!!}
                            <input type="hidden" name="BusinessID" value="{{ $business['BusinessID'] ?? '' }}">
                            <h5 class="text-title text-uppercase">Business Information</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Scope</label>
                                        {!!Form::select("business_scope", $business_scopes, old('business_scope'), ['id' => "input_business_scope", 'class' => "form-control form-control-sm classic ".($errors->first('business_scope') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('business_scope'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_scope')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Type</label>
                                        {!!Form::select("business_type", $business_types, old('business_type'), ['id' => "input_business_type", 'class' => "form-control form-control-sm classic ".($errors->first('business_type') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('business_type'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_type')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Dominant Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('dominant_name') ? 'is-invalid': NULL  }}"  name="dominant_name" value="{{old('dominant_name') }}">
                                        @if($errors->first('dominant_name'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('dominant_name')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('dominant_name') ? 'is-invalid': NULL  }}"  name="business_name" value="{{old('business_name', $business['BusinessName'] ?? '') }}">
                                        @if($errors->first('business_name'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_name')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group {{$errors->first('no_male_employee') ? 'text-danger' : NULL}}">
										<label for="input_no_male_employee" class="text-form pb-2">Total No. of Male Employees</label>
										<input type="number" id="input_no_male_employee" class="form-control" name="no_male_employee" value="{{old('no_male_employee',session()->get('soleproprietorship.new_business.no_male_employee'))}}">
										@if($errors->first('no_male_employee'))
										<p class="help-block text-danger">{{$errors->first('no_male_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group {{$errors->first('male_residing_in_city') ? 'text-danger' : NULL}}">
										<label for="input_male_residing_in_city" class="text-form pb-2">No. of Male Employees Residing In City</label>
										<input type="number" id="input_male_residing_in_city" class="form-control" name="male_residing_in_city" value="{{old('male_residing_in_city',session()->get('soleproprietorship.new_business.male_residing_in_city'))}}">
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
										<input type="number" id="input_no_female_employee" class="form-control" name="no_female_employee" value="{{old('no_female_employee',session()->get('soleproprietorship.new_business.no_female_employee'))}}">
										@if($errors->first('no_female_employee'))
										<p class="help-block text-danger">{{$errors->first('no_female_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group {{$errors->first('female_residing_in_city') ? 'text-danger' : NULL}}">
										<label for="input_female_residing_in_city" class="text-form pb-2">No. of Female Employees Residing In City</label>
										<input type="number" id="input_female_residing_in_city" class="form-control" name="female_residing_in_city" value="{{old('female_residing_in_city',session()->get('soleproprietorship.new_business.female_residing_in_city'))}}">
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
                                        {!!Form::select("business_line[]", $lob ?? [],old('business_line'), ['id' => "input_business_line", 'multiple' => 'multiple','class' => "custom-select select2 mb-2 mr-sm-2 ".($errors->first('business_line') ? 'is-invalid' : NULL)])!!}
                                        @if($errors->first('business_line'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_line')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Capitalization</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('capitalization') ? 'is-invalid': NULL  }}"  name="capitalization" value="{{old('capitalization') }}">
                                        @if($errors->first('capitalization'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('capitalization')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="region_name" id="input_region_name" value="{{old('region_name', 'REGION IX (ZAMBOANGA PENINSULA)')}}">
                            <input type="hidden" class="form-control" name="town_name" id="input_town_name" value="{{old('town_name', 'ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA')}}">
                            <input type="hidden" class="form-control" name="brgy_name" id="input_brgy_name" value="{{old('brgy_name')}}">

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1" class="text-form pb-2">Region</label>
                                       {!!Form::select('region',[],old('region'),['id' => "input_region",'class' => "form-control form-control-sm classic ".($errors->first('region') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('region'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('region')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        {!!Form::select('town',[],old('town'),['id' => "input_town",'class' => "form-control form-control-sm classic ".($errors->first('town') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('town'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('town')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        {!!Form::select('brgy',[],old('brgy'),['id' => "input_brgy",'class' => "form-control form-control-sm classic ".($errors->first('brgy') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('brgy'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('brgy')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <input type="text" id="input_zipcode" class="form-control form-control-sm  {{ $errors->first('zipcode') ? 'is-invalid': NULL  }}" name="zipcode" value="{{old('zipcode')}}" readonly="readonly">
                                        @if($errors->first('zipcode'))
                                        <p class="help-block text-danger">{{$errors->first('zipcode')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('unit_no') ? 'is-invalid': NULL  }}"  name="unit_no" value="{{old('unit_no'), ($business['BusBldgName'] ?? '').' '.($business['BusBldgNo'] ?? '')}}">
                                        @if($errors->first('unit_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('unit_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('street_address') ? 'is-invalid': NULL  }}"  name="street_address" value="{{old('street_address', $business['BusStreet'] ?? '') }}">
                                        @if($errors->first('street_address'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('street_address')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('email') ? 'is-invalid': NULL  }}"  name="email" value="{{old('email', $business['BusEmailAddress'] ?? '') }}">
                                        @if($errors->first('email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('email')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Website (URL)</label>
                                        <input type="url" class="form-control form-control-sm {{ $errors->first('website_url') ? 'is-invalid': NULL  }}"  name="website_url" value="{{old('website_url', $business['BusWebsite'] ?? '') }}">
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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('mobile_no') ? 'is-invalid': NULL  }}"  name="mobile_no" value="{{old('mobile_no') }}">
                                        @if($errors->first('mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('telephone_no') ? 'is-invalid': NULL  }}"  name="telephone_no" value="{{old('telephone_no',$business['BusTelNo'] ?? '') }}">
                                        @if($errors->first('telephone_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('telephone_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center">
                                                <th class="text-form text-uppercase">Line of Business</th>
                                            </thead>
                                            <tbody class="multi-field-wrapper">
                                                @if (!empty($lob))
                                                    @foreach ($lob as $key => $item)
                                                    <div class="multi-fields">
                                                        <div class="multi-field">
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" name="line_of_business[]" value="{{ $item }}">
                                                                    <button type="button" class="btn btn-danger">Remove</button>
                                                                </td>
                                                            </tr>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" name="line_of_business[]" value="">
                                                        </td>
                                                    </tr>
                                                @else
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" name="line_of_business[]" value="">
                                                    </td>
                                                </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn badge-primary-2 text-white mr-2 add-field" style="float: left;">hindi ako gumagana wag i-click</button>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="multi-field-wrapper">
                                    <div class="multi-fields">
                                        <div class="multi-field">
                                            <input type="text" name="stuff[]">
                                            <button type="button" class="remove-field">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" class="add-field">Add field</button>
                                </div> --}}
                                <script>
                                    $(function(){
                                        function addField( $wrapper ) {
                                            var $elem = $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('td');
                                            $elem.val('').focus();
                                            return $elem;
                                        }
                                        $('.multi-field-wrapper').each(function() {
                                            var $wrapper = $('.multi-fields', this);
                                            $(".add-field", $(this)).click(function(e) {
                                                addField( $wrapper )
                                                console.log('asdsad');
                                            });
                                            $('.multi-field .remove-field', $wrapper).click(function() {
                                                if ($('.multi-field', $wrapper).length > 1)
                                                    $(this).parent('.multi-field').remove();
                                            });
                                        });
                                    })
                                </script>
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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('tin_no') ? 'is-invalid': NULL  }}"  name="tin_no" value="{{old('tin_no', $business['BusTIN'] ?? '') }}">
                                        @if($errors->first('tin_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('tin_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">SSS No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('sss_no') ? 'is-invalid': NULL  }}"  name="sss_no" value="{{old('sss_no') }}">
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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('philhealth_no') ? 'is-invalid': NULL  }}"  name="philhealth_no" value="{{old('philhealth_no') }}">
                                        @if($errors->first('philhealth_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('philhealth_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">PAGIBIG No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('pagibig_no') ? 'is-invalid': NULL  }}"  name="pagibig_no" value="{{old('pagibig_no') }}">
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
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css">
  .is-invalid{
    border: solid 2px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    font-size: 18px;
  }
  span.select2.select2-container{
    width: 100% !important;
  }
</style>
@endsection

@section('page-scripts')
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>

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
        $('.select2').select2({
            tags: true,
        });
        load_barangay();
        $(this).get_region("#input_region","#input_province","#input_town","#input_brgy","{{old('region', '090000000')}}")
        $(this).get_city("090000000", "#input_town", "#input_brgy", "{{old('town', '097332000')}}");
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

        function load_barangay() {
            var _val = "097332000";
            var _text = "ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA";
            $(this).get_brgy(_val, "#input_brgy", "");
            $('#input_zipcode').val('');
            $('#input_town_name').val(_text);
        }

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
