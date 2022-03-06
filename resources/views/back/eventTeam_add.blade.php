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
        <h5>New {{ (isset($titles->titleSingular)) ? $titles->titleSingular : '' }}</h5>
      </div>
      <div class="card-body">
        <form id="form">
          @csrf
          <div class="row">
            {{-- <!-- <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Game *</label>
                <select class="game form-control" name="game" id="game">
                  <option value="">Select Game</option>
                  @foreach($games as $key=>$val)
                  <option value="{{ $val->id }}">{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div> --> --}}

            {{-- <!-- <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Event *</label>
                <select class="event form-control" name="event" id="event">
                  <option value="">Select Event</option>
                  @foreach($events as $key=>$val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div> --> --}}

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Team *</label>
                <select class="team form-control" name="team" id="team">
                  <option value="">Select Teams</option>
                  @foreach($teams as $key=>$val)
                  <option value="{{ $val->id }}">{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            
          </div>
        </form>
      </div>
      <div class="card-footer">
        <input type="hidden" name="event_id" id="event_id" value="{{ $event_id }}" />
        <button type="button" name="submit" class="btn btn-primary" onclick="store()">Save</button>
        <a class="btn btn-default" onclick="cancel('{{ url(admin().'/events/'.$event_id.'/'.$titles->viewPathPrefix) }}')">Cancel</a>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/eventTeams.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- form-select-custom Js -->
<!-- <script src="{{ back_asset('js/pages/form-select-custom.js') }}"></script> -->
<script>
  $("#game").select2();
  $("#event").select2();
  $("#team").select2();

  $('#game').on('change',function(){
    let game_id = $(this).val();
    getEventsBYGame(game_id,'event');
  });

</script>
@endsection