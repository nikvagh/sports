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
                <label>Team *</label>
                <select class="team form-control" name="team" id="team">
                  <option value="">Select Teams</option>
                  @foreach($teams as $key=>$val)
                  <option value="{{ $val->id }}" {{ ($row->team_id == $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Coach *</label>
                <input type="text" class="form-control" name="coach" value="{{ $row->coach }}">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Owner *</label>
                <input type="text" class="form-control" name="owner" value="{{ $row->coach }}">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Caption *</label>
                <input type="text" class="form-control" name="caption" value="{{ $row->caption }}">
              </div>
            </div>
          </div>
          
        </form>
      </div>
      <div class="card-footer">
        <input type="hidden" name="event_id" id="event_id" value="{{ $event_id }}" />
        <button type="button" name="submit" id="submit" class="btn btn-primary" onclick="update({{ $row->id }})">Save</button>
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
  $("#caption").select2();
</script>
@endsection