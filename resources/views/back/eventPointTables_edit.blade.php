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

            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Team</th>
                  <th>Matches</th>
                  <th>Win</th>
                  <th>Lose</th>
                  <th>Net Run rate</th>
                  <th>Points</th>
                </tr>
              </thead>
              @foreach($teams as $key=>$val)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $val->team->name }}</td>
                  <td><input type="text" class="form-control" name="match[{{$val->id}}]" value="{{ ($val->eventPointTable) ? $val->eventPointTable->match : '' }}"></td>
                  <td><input type="text" class="form-control" name="win[{{$val->id}}]" value="{{ ($val->eventPointTable) ? $val->eventPointTable->win : '' }}"></td>
                  <td><input type="text" class="form-control" name="lose[{{$val->id}}]" value="{{ ($val->eventPointTable) ? $val->eventPointTable->lose : '' }}"></td>
                  <td><input type="text" class="form-control" name="nrr[{{$val->id}}]" value="{{ ($val->eventPointTable) ? $val->eventPointTable->nrr : '' }}"></td>
                  <td><input type="text" class="form-control" name="points[{{$val->id}}]" value="{{ ($val->eventPointTable) ? $val->eventPointTable->points : '' }}"></td>
                </tr>
              @endforeach
            </table>

        </form>
      </div>
      <div class="card-footer">
        <input type="hidden" name="event_id" id="event_id" value="{{ $event_id }}">
        <button type="button" name="submit" id="submit" class="btn btn-primary" onclick="eventPointTables_update({{$event_id}})">Save</button>
        <a class="btn btn-default" onclick="cancel('{{ url(admin().'/'.$titles->viewPathPrefix) }}')">Cancel</a>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/events.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- form-select-custom Js -->
<!-- <script src="{{ back_asset('js/pages/form-select-custom.js') }}"></script> -->
<script>
  $("#game").select2();
</script>
@endsection