@extends('layouts.dash')

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
                <label>Name *</label>
                <input type="text" class="form-control" name="name" value="{{ $row->name }}">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Email *</label>
                <input type="text" class="form-control" name="email" value="{{ $row->email }}">
              </div>
            </div>

            @if($row->user_type == 'user')
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password" value="">
              </div>
            </div>
            @endif

          </div>
        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary save_btn" onclick="update({{ $row->id }})">Save</button>
        <a class="btn btn-default" onclick="cancel('{{ url(admin().'/'.$titles->viewPathPrefix) }}')">Cancel</a>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/users.js') }}"></script>
@endsection