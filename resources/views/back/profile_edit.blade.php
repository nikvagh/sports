@extends('layouts.dash')

@section('content')
<div class="row">
  <div class="col-sm-12">

    @include(backView().'.includes.alert-popup')

    <div class="card">
      <div class="card-header">
        <h5>Edit Profile</h5>
      </div>
      <div class="card-body">
        <form id="form">
          @csrf
          <div class="row">
            
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Name *</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Email *</label>
                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
              </div>
            </div>

          </div>
          <input type="hidden" name="id" value="{{ $user->id }}">
        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary save_btn" onclick="update({{ $user->id }})">Save</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/profile.js') }}"></script>
@endsection