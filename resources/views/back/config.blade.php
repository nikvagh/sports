@extends('layouts.dash')

@section('css')
<!-- select2 css -->
<link rel="stylesheet" href="{{ back_asset('css/plugins/select2.min.css') }}">
<link rel="stylesheet" href="{{ back_asset('css/plugins/daterangepicker.css') }}">
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">

    @include(backView().'.includes.alert-popup')

    <div class="card">
      <div class="card-header">
        <h5>Edit {{ (isset($titles->titleSingular)) ? $titles->titleSingular : '' }}</h5>
      </div>
      <div class="card-body">
        <form id="form">
          @csrf

          <div class="row">
            <div class="col-sm-12">

              <table class="table">
                <thead>
                  <tr>
                    <th>Option</th>
                    <th>value</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>API Token</td>
                    <td><input type="text" name="api_token" class="form-control" value="{{ $configs['api_token'] }}"/></td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
          
        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary" onclick="update()">Save</button>
        <a class="btn btn-default" onclick="cancel('{{ url(admin().'/'.$titles->viewPathPrefix) }}')">Cancel</a>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/configs.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- datepicker js -->
<script src="{{ back_asset('js/plugins/moment.min.js') }}"></script>
<script src="{{ back_asset('js/plugins/daterangepicker.js') }}"></script>
<!-- <script src="{{ back_asset('js/pages/ac-datepicker.js') }}"></script> -->
<script>
  $(".select2").select2();

  // $('input[name="match_time"]').daterangepicker({
	// 	timePicker: true,
  //   timePicker24Hour: true,
	// 	locale: {
	// 	  format: 'YYYY-MM-DD hh:mm'
	// 	},
  //   singleDatePicker: true
	// });

</script>
@endsection