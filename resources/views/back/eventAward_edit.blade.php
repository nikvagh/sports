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
                <label>Title *</label>
                <input type="text" class="form-control" name="title" value="{{ $row->title }}">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Slug * (You can not change the value of slug once you saved) </label>
                <input type="text" class="form-control" name="slug" value="{{ $row->slug }}" readonly>
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