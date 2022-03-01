@extends('layouts.dash')

@section('css')
<!-- select2 css -->
<link rel="stylesheet" href="{{ back_asset('css/plugins/select2.min.css') }}">
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
                <label>Award Type *</label>
                <select class="select2 form-control" name="award_type" id="award_type">
                  <option value="">Select Award Type</option>
                  <option value="team" {{ ($row->award_type == 'team') ? 'selected' : '' }}>Team</option>
                  <option value="player" {{ ($row->award_type == 'player') ? 'selected' : '' }}>Player</option>
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
                  <!-- <optgroup label="Game : {{ $val->name }}"> -->
                  @foreach($val->events as $key1=>$val1)
                  <optgroup label="&nbsp;&nbsp; Event : {{ $val1->name }}">
                    @foreach($val1->teams as $key2=>$val2)
                    <option value="{{ $val2->id }}" {{ ($row->event_awardable_id == $val2->id) ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp; {{ $val2->name }}</option>
                    @endforeach
                  </optgroup>
                  @endforeach
                  <!-- </optgroup> -->
                  @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6 player_box">
              <div class="form-group mb-3">
                <label>Players *</label>
                <select class="select2 form-control" name="player" id="player">
                  <option value="">Select Player</option>
                  @foreach($games as $key=>$val)
                  @if($val->events->count() > 0)
                  <!-- <optgroup label="Game : {{ $val->name }}"> -->
                  @foreach($val->events as $key1=>$val1)
                  <optgroup label="Event : {{ $val1->name }}">
                    @foreach($val1->teams as $key2=>$val2)
                  <optgroup label="&nbsp;&nbsp; Teams : {{ $val2->name }}">
                    @foreach($val2->teamPlayers as $key3=>$val3)
                    <option value="{{ $val3->id }}" {{ ($row->event_awardable_id == $val3->player_id && $row->event_id == $val1->id) ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp; {{ $val3->player->name }}</option>
                    @endforeach
                  </optgroup>
                  @endforeach
                  </optgroup>
                  @endforeach
                  <!-- </optgroup> -->
                  @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Title *</label>
                <input type="text" class="form-control" name="title" value="{{ $row->title }}">
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
<script src="{{ back_asset('js/custom/eventAward.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- form-select-custom Js -->
<!-- <script src="{{ back_asset('js/pages/form-select-custom.js') }}"></script> -->
<script>
  $(".select2").select2();

  @if($row->award_type == 'team')
    $('.player_box').hide();
  @endif

  @if($row->award_type == 'player')
    $('.team_box').hide();
  @endif

  var award_type = '';
  $("#award_type").change(function() {
    let award_type = $(this).val();
    $('.team_box').hide();
    $('.player_box').hide();
    if (award_type == 'team') {
      $('.team_box').show();
    } else if (award_type == 'player') {
      $('.player_box').show();
    }
  });
</script>
@endsection