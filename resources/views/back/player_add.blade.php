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
                <select class="select2 form-control" name="game" id="game">
                  <option value="">Select Game</option>
                  @foreach($games as $key=>$val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Role *</label>
                <select class="select2 form-control role" name="role" id="role">
                  <option value="">Select Role</option>
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Name *</label>
                <input type="text" class="form-control" name="name" value="">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-10">
                  <label>Profile </label>
                  <div class="input-group mb-3">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="profile" id="profile" accept="image/*"  onchange="document.getElementById('profile_img').src = window.URL.createObjectURL(this.files[0])">
                      <label class="custom-file-label" for="profile">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 d-flex align-items-center">
                  <img src="{{ url(back_asset('images/no-img.png')) }}" alt="" class="img-fluid" id="profile_img">
                </div>
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
<script src="{{ back_asset('js/custom/players.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<script>
  $(".select2").select2();

  $('#game').on('change',function(){
    let game_id = $(this).val();
    // $(".teams").find('option').remove().end().append($("<option></option>") .attr("value", '').text('Select Team')); 
    getRoleByGame(game_id,'role');
  });

</script>
@endsection