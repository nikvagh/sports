@extends('layouts.dash')

@section('css')
<!-- select2 css -->
<!-- <link rel="stylesheet" href="{{ back_asset('css/plugins/select2.min.css') }}"> -->
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">

    @include(backView().'.includes.alert-popup')

    <div class="card">
      <div class="card-header">
        <h5>Edit Highlight Video [Match id #{{ $row->id }} {{ $row->team1->name }} vs {{ $row->team2->name }}]</h5>
      </div>
      <div class="card-body">
        <form id="form">
          @csrf

          <div class="row">

            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-10">
                  <label>Highlight Video *</label>
                  <div class="input-group mb-3">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="video" id="video" accept="video/*"  onchange="">
                      <label class="custom-file-label" for="profile">Choose file</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @if($highlight)
              <div class="col-lg-4 col-sm-6">
                <div class="thumbnail mb-4">
                    <div class="thumb">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe allowfullscreen="" src="{{ $highlight->videoUrl }}"></iframe>
                        </div>
                    </div>
                </div>
              </div>
            @endif

          </div>
          
        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary" onclick="updateHighlight({{ $row->id }})">Save</button>
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
<!-- <script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script> -->
<!-- form-select-custom Js -->
<!-- <script src="{{ back_asset('js/pages/form-select-custom.js') }}"></script> -->
<script>
  // $(".select2").select2();
</script>
@endsection