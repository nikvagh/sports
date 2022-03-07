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
            
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Game *</label>
                <select class="select2 form-control" name="game" id="game">
                  <option value="">Select Game</option>
                  @foreach($games as $key=>$val)
                    <option value="{{ $val->id }}" {{ ($game_selected->id == $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Event *</label>
                <select class="select2 form-control" name="event" id="event">
                  <option value="">Select Event</option>
                  @foreach($events as $key=>$val)
                    <option value="{{ $val->id }}" {{ ($event_selected->id == $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Team 1 *</label>
                <select class="select2 form-control teams" name="team_1" id="team_1">
                  <option value="">Select Team 1</option>

                  @foreach($teams as $key=>$val)
                    <option value="{{ $val->id }}" {{ ($team1_selected->id == $val->id) ? 'selected' : '' }}>{{ $val->team->name }}</option>
                  @endforeach

                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Team 2 *</label>
                <select class="select2 form-control teams" name="team_2" id="team_2">
                  <option value="">Select Team 2</option>

                  @foreach($teams as $key=>$val)
                    <option value="{{ $val->id }}" {{ ($team2_selected->id == $val->id) ? 'selected' : '' }}>{{ $val->team->name }}</option>
                  @endforeach

                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Stadium *</label>
                <select class="select2 form-control stadium" name="stadium" id="stadium">
                  <option value="">Select Stadium</option>

                  @foreach($stadiums as $key=>$val)
                    <option value="{{ $val->id }}" {{ ($stadium_selected->id == $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
                  @endforeach

                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Match Date Time *</label>
                <input type="text" class="form-control" name="match_time" value="{{ $row->match_time }}">
              </div>
            </div>

          </div>
          
        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary" onclick="update({{ $row->id }})">Save</button>
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

  $('#game').on('change',function(){
    let game_id = $(this).val();
    $(".teams").find('option').remove().end().append($("<option></option>") .attr("value", '').text('Select Team')); 
    getEventsBYGame(game_id,'event');
  });

  $('#event').on('change',function(){
    let event_id = $(this).val();
    getTeamsBYEvent(event_id,'teams');
    getStadiumsByEvent(event_id,'stadium');
  });
</script>
@endsection