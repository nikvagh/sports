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
                <label>Players *</label>
                <select class="team form-control" name="player" id="player">
                  <option value="">Select Player</option>
                  @foreach($players as $key=>$val)
                  <option value="{{ $val->id }}" {{ ($row->player_id == $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Price *</label>
                <input type="number" class="form-control" name="price" value="{{ $row->price }}">
              </div>
            </div>
          
          </div>
        </form>
      </div>
      <div class="card-footer">
        <input type="hidden" name="event_id" id="event_id" value="{{ $event_id }}" />
        <input type="hidden" name="event_team_id" id="event_team_id" value="{{ $event_team_id }}" />
        <button type="button" name="submit" id="submit" class="btn btn-primary" onclick="update({{ $row->id }})">Save</button>
        <a class="btn btn-default" onclick="cancel('{{ url(admin().'/events/'.$event_id.'/eventTeams/'.$event_team_id.'/'.$titles->viewPathPrefix) }}')">Cancel</a>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/eventTeamPlayers.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- form-select-custom Js -->
<!-- <script src="{{ back_asset('js/pages/form-select-custom.js') }}"></script> -->
<script>
  $("#game").select2();
</script>
@endsection