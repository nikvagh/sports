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
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Team 1 *</label>
                <select class="select2 form-control" name="team_1">
                  <option value="">Select Team 1</option>
                  @foreach($games as $key=>$val)
                  @if($val->events->count() > 0)
                  <optgroup label="Game: {{ $val->name }}">
                    @foreach($val->events as $key1=>$val1)
                  <optgroup label=" &nbsp;&nbsp; Event: {{ $val1->name }}">
                    @foreach($val1->teams as $key2=>$val2)
                    <option value="{{ $val2->id }}">&nbsp;&nbsp;&nbsp; {{ $val2->name }}</option>
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
                <label>Team 2 *</label>
                <select class="select2 form-control" name="team_2">
                  <option value="">Select Team 2</option>
                  @foreach($games as $key=>$val)
                  @if($val->events->count() > 0)
                  <optgroup label="Game: {{ $val->name }}">
                    @foreach($val->events as $key1=>$val1)
                  <optgroup label=" &nbsp;&nbsp; Event:  {{ $val1->name }}">
                    @foreach($val1->teams as $key2=>$val2)
                    <option value="{{ $val2->id }}">&nbsp;&nbsp;&nbsp; {{ $val2->name }}</option>
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
                <label>Stadium *</label>
                <select class="select2 form-control" name="stadium">
                  <option value="">Select Stadium</option>
                  @foreach($gamesForStadium as $key=>$val)
                  @if($val->events->count() > 0)
                  <optgroup label="Game: {{ $val->name }}">
                    @foreach($val->events as $key1=>$val1)
                  <optgroup label=" &nbsp;&nbsp; Event: {{ $val1->name }}">
                    @foreach($val1->stadiums as $key2=>$val2)
                    <option value="{{ $val2->id }}">&nbsp;&nbsp;&nbsp; {{ $val2->name }}</option>
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
                <label>Match Date Time *</label>
                <input type="text" class="form-control" name="match_time" value="">
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
<script src="{{ back_asset('js/custom/matches.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- datepicker js -->
<script src="{{ back_asset('js/plugins/moment.min.js') }}"></script>
<script src="{{ back_asset('js/plugins/daterangepicker.js') }}"></script>
<!-- <script src="{{ back_asset('js/pages/ac-datepicker.js') }}"></script> -->
<script>
  $(".select2").select2();

  $('input[name="match_time"]').daterangepicker({
		timePicker: true,
    timePicker24Hour: true,
		locale: {
		  format: 'YYYY-MM-DD hh:mm'
		},
    singleDatePicker: true
	});
</script>
@endsection