

  const MODEL = 'applicationVideos'; 
  var dtTable1;
  const list = () => {
    dtTable1 = $('#dtTable1').DataTable({
      "order": [0, "desc"],
      processing: true,
      serverSide: true,
      ajax: {
        url:MODEL+'/list_data',
        // columnDefs: [{
        //     className: 'dtr-control',
        //     orderable: false,
        //     targets:   0
        // }],
        // data: function (d) {
        //   d.game = $("#game").val();
        //   d.event = $("#event").val();
        // },
      },
      columns: [
        {
          data: 'id',
          name: 'id'
        },
        // {
        //   "render": function (data, type, row, meta) {
        //     return '<img src="'+row.wallpaperUrl+'" width="80"/>';
        //   },
        //   "orderable": false,
        //   "searchable": false,
        //   data:'video',
        //   name: 'video'
        // },
        {
          data:'video',
          name: 'video'
        },
        {
          data: 'application.name',
          name: 'application.name'
        },
        {
          data: "action"
        }
      ]
    });
  }

  const validation = (formData) => {
    $(".validation-popup").css('display','none');
    var call = ajaxCall('/'+ADMIN+'/'+MODEL+'/validation', 'post', 'json', formData, []);
    userAuth(call);
    if (call.status == 200) {
      let response = call.responseJSON;

      if (response.status != 200) {
        let errorText = '';
        response.result.forEach(element => {
            errorText += element+"<br/>";
        });
        flashAlert(errorText,'error');
        btn_disable(false,'save_btn','Save');
        return false;
      } else {
        return true;
      }

    }
  }

  const store = () => {
    btn_disable(true,'save_btn','validating, Please Wait...');
    var formData = new FormData(document.getElementById('form'));
    formData.append('action','create');
    if (validation(formData)) {
      btn_disable(true,'save_btn','saving, Please Wait...');
      var call = ajaxCall('/'+ADMIN+'/'+MODEL, 'post', 'json', formData, []);
      userAuth(call);
      if (call.status == 200) {
        let response = call.responseJSON;
        // $('.success-popup span').html(response.title);
        // $(".success-popup").fadeTo(3000, 500).slideUp(500);
        window.location.replace(response.result.next);
      }

    }
  }

  const update = (id) => {
    
    btn_disable(true,'save_btn','validating, Please Wait...');
    var formData1 = new FormData(document.getElementById('form'));
    formData1.append('action','update');
    if (validation(formData1)) {
      btn_disable(true,'save_btn','saving, Please Wait...');
      var formData2 = formData1;
      formData2.append('_method','PUT');
      
      var call = ajaxCall('/'+ADMIN+'/'+MODEL+'/'+id, 'post', 'json', formData2, []);
      userAuth(call);
      if (call.status == 200) {
        let response = call.responseJSON;
        window.location.replace(response.result.next);
      }

    }
  }

  const deleteRow = (id) => {
    var formData = new FormData(document.getElementById('deleteForm'));
    var call = ajaxCall('/'+ADMIN+'/'+MODEL+'/'+id, 'post', 'json', formData, []);
    userAuth(call);
    if (call.status == 200) {
      $('#confirm_model').modal('hide');

      let response = call.responseJSON;
      flashAlert(response.title,'success',300);

      dtTable1.ajax.reload(null, false);
    }
  }