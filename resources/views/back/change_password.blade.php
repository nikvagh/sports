@extends('layouts.dash')

@section('content')
<div class="row">
  <div class="col-sm-12">

    @include(backView().'.includes.alert-popup')

    <div class="card">
      <div class="card-header">
        <h5>Change Password</h5>
      </div>
      <div class="card-body">
        <form id="form">
          @csrf
          <div class="row">
            
            <div class="col-sm-4">
              <div class="form-group mb-3">
                <label>Old Password *</label>
                <input type="password" class="form-control" name="old_password" value="">
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group mb-3">
                <label>New Password *</label>
                <input type="password" class="form-control" name="new_password" value="">
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group mb-3">
                <label>New Confirm Password *</label>
                <input type="password" class="form-control" name="new_confirm_password" value="">
              </div>
            </div>

          </div>
          <input type="hidden" name="id" value="{{ $user->id }}">
        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary save_btn" onclick="updatePassword({{ $user->id }})">Save</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/profile.js') }}"></script>
@endsection