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
        <h5>New {{ (isset($titles->titleSingular)) ? $titles->titleSingular : '' }}</h5>
      </div>
      <div class="card-body">
        <form id="form">
          @csrf
          <div class="row">

            <div class="col-sm-6 team_box">
              <div class="form-group mb-3">
                <label>Event *</label>
                <select class="select2 form-control" name="event" id="event">
                  <option value="">Select Event</option>
                  @foreach($games as $key=>$val)
                    @if($val->events->count() > 0)
                    <optgroup label="Game : {{ $val->name }}">
                      @foreach($val->events as $key1=>$val1)
                        <option value="{{ $val1->id }}">&nbsp;&nbsp; {{ $val1->name }}</option>
                      @endforeach
                    </optgroup>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6 team_box">
              <div class="form-group mb-3">
                <label>Team *</label>
                <select class="select2 form-control" name="team" id="team">
                  <option value="">Select Team</option>
                  @foreach($games as $key=>$val)
                    @if($val->events->count() > 0)
                    <optgroup label="Game : {{ $val->name }}">
                      @foreach($val->events as $key1=>$val1)
                      <optgroup label="&nbsp;&nbsp; Event :  {{ $val1->name }}">

                        @foreach($val1->teams as $key2=>$val2)
                          <option value="{{ $val2->id }}">&nbsp;&nbsp;&nbsp;&nbsp;  {{ $val2->name }}</option>
                        @endforeach

                      </optgroup>
                      @endforeach
                    </optgroup>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Year *</label>
                <input type="text" class="form-control" name="year" id="year" value="">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-10">
                  <label>Image </label>
                  <div class="input-group mb-3">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="image" id="image" accept="image/*"  onchange="document.getElementById('image_img').src = window.URL.createObjectURL(this.files[0])">
                      <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 d-flex align-items-center">
                  <img src="{{ url(back_asset('images/no-img.png')) }}" alt="" class="img-fluid" id="image_img">
                </div>
              </div>
            </div>
            
          </div>
        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary" onclick="store()">Save</button>
        <a class="btn btn-default" onclick="cancel('{{ url(admin().'/'.$titles->viewPathPrefix) }}')">Cancel</a>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/eventWinners.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- datepicker js -->
<script src="{{ back_asset('js/plugins/moment.min.js') }}"></script>
<script src="{{ back_asset('js/plugins/daterangepicker.js') }}"></script>

<script>
  $(".select2").select2();

  // $('input[name="year"]').daterangepicker({
	// 	timePicker: false,
  //   // timePicker24Hour: true,
	// 	locale: {
	// 	  format: 'YYYY'
	// 	},
  //   // viewMode: "years", 
  //   // minViewMode: "weeks",
  //   singleDatePicker: true
	// });

</script>
@endsection