@extends('layouts.dash')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">

    @include(backView().'.includes.alert-popup')

    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h5>{{ $titles->breadCrumbTitle }} List</h5>
          </div>
          <div class="col-md-6 text-right">
            <a href="{{ url(admin().'/'.$titles->viewPathPrefix.'/create') }}" class="btn btn-primary"><i class="feather icon-edit-1"></i> Add New {{ $titles->titleSingular }}</a>
          </div>
        </div>
      </div>
      <div class="card-body">

        <div class="dt-responsive table-responsive">
          <table id="dtTable1" class="table table-bordered table-striped display nowrap" width="100%">
            <thead>
              <tr>
                <!-- <th></th> -->
                <th>Id</th>
                <th>Logo</th>
                <th>Name</th>
                <!-- <th>Point</th> -->
                <!-- <th>Game</th> -->
                <!-- <th>Event</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <div id="example1_processing" class="dataTables_processing" style="display: none;">Processing...</div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="confirm_model">
</div>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/teams.js') }}"></script>

<script>
  list();
</script>
@endsection