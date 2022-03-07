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

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Game *</label>
                <select class="select2 form-control game" name="game" id="game">
                  <option value="">Select Game</option>
                  @foreach($games as $key=>$val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Event *</label>
                <select class="select2 form-control event" name="event" id="event">
                  <option value="">Select Event</option>
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Award *</label>
                <select class="select2 form-control award" name="award" id="award">
                  <option value="">Select Award</option>
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Player *</label>
                <select class="select2 form-control player" name="player" id="player">
                  <option value="">Select Player</option>
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Total *</label>
                <input type="number" class="form-control" name="total" value="">
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
<script src="{{ back_asset('js/custom/eventAwardHolders.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<script>
  $(".select2").select2();
  $('#game').on('change',function(){
    let game_id = $(this).val();
    $(".award").find('option').remove().end().append($("<option></option>") .attr("value", '').text('Select Team')); 
    getEventsBYGame(game_id,'event');
  });
  $('#event').on('change',function(){
    let event_id = $(this).val();
    getAwardsByEvent(event_id,'award');
    getPlayersByEvent(event_id,'player');
  });
</script>
@endsection