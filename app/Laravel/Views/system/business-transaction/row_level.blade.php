<tr id="lob-{{ $key_level }}">
<td>
    {!!Form::select("business_linep[]", $line_of_businesses, old('business_line[]', $item->b_class."---".$item->s_class."---".($item->x_class ? $item->x_class:"0")."---".$item->account_code), ['id' => "input_business_scope", 'class' => "form-control classic ".($errors->first('business_line.*') ? 'border-red' : NULL)])!!}
  </td>
  <td>
    <input type="text" class="form-control form-control-sm {{ $errors->first('no_of_units.*') ? 'is-invalid': NULL  }}"  name="no_of_units[]" value="{{old('no_of_units[]' , $item->no_of_unit) }}">
    @include('system.business-transaction.error', ['error_field' => 'no_of_units.*'])
  </td>
  <td>
    <div class="form-group my-0">
        <input type="text" class="form-control form-control-sm {{ $errors->first('amount[]') ? 'is-invalid': NULL  }}"  name="amount[]" value="{{old('amount[]', $item->gross_sales) }}">
        @include('system.business-transaction.error', ['error_field' => 'amount[]'])
    </div>
  </td>
  <td><a class="btn btn-xs lob-remove" data-essence="#lob-{{ $key_level }}" data-count=""><i class="fas fa-trash text-danger"></i></a></td>
</tr>
