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
        <h5>Send {{ (isset($titles->titleSingular)) ? $titles->titleSingular : '' }}</h5>
      </div>
      <div class="card-body">
        <form id="form">
          @csrf

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Application *</label>
                <select class="team form-control" name="application" id="application">
                  <option value="">Select Application</option>
                  @foreach($applications as $key=>$val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Title *</label>
                <input type="text" class="form-control" name="title" value="">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label>Description *</label>
                <textarea class="form-control" name="description"></textarea>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-10">
                  <label>Icon </label>
                  <div class="input-group mb-3">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="icon" id="icon" accept="image/*"  onchange="document.getElementById('icon_img').src = window.URL.createObjectURL(this.files[0])">
                      <label class="custom-file-label" for="icon">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 d-flex align-items-center">
                  <img src="" alt="" class="img-fluid" id="icon_img">
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
      <div class="card-footer">
        <button type="button" name="submit" class="btn btn-primary" onclick="update()">Save</button>
        <a class="btn btn-default" onclick="cancel('{{ url(admin().'/'.$titles->viewPathPrefix) }}')">Cancel</a>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ back_asset('js/custom/custom.js') }}"></script>
<script src="{{ back_asset('js/custom/notifications.js') }}"></script>

<!-- select2 Js -->
<script src="{{ back_asset('js/plugins/select2.full.min.js') }}"></script>
<!-- datepicker js -->
<script src="{{ back_asset('js/plugins/moment.min.js') }}"></script>
<script>
  $(".select2").select2();
</script>


<script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
<script>

  var ip_address = "{{ env('APP_HOST') }}";
  var socket_port = "{{ env('SOCKET_PORT') }}";
  // console.log(ip_address + ':' + socket_port);
  let socket = io(ip_address + ':' + socket_port);

  const update = () => {
    btn_disable(true,'save_btn','validating, Please Wait...');
    var formData1 = new FormData(document.getElementById('form'));
    if (validation(formData1)) {
      btn_disable(true,'save_btn','saving, Please Wait...');
      var formData2 = formData1;
      // formData2.append('_method','PUT');
      
      var call = ajaxCall('/'+ADMIN+'/'+MODEL+'/update', 'post', 'json', formData2, []);
      userAuth(call);
      if (call.status == 200) {
        let response = call.responseJSON;
        // console.log(response);
        // window.location.replace(response.result.next);

        // push notification code ===================================
        let notification = response.result.notification;
        let title = notification.title;
        let description = notification.description;
        let icon = notification.icon;
        let deviceTokens = notification.deviceTokens;
        
        let socketData = {
          'title': title,
          'message': description,
          'icon': icon,
          'deviceTokens': deviceTokens,
        }
        let result = socket.emit('new_notification', socketData);
        // console.log(result);
        // return false;

        flashAlert('Notification successfully','success',300);
        // push notification code end===================================
        document.getElementById('form').reset();
      }

    }
  }

  socket.on('show_notification', (data) => {
      console.log(data);
  });

</script>
@endsection