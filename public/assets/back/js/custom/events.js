

  const MODEL = 'events'; 
  var dtTable1;
  const list = () => {
    dtTable1 = $('#dtTable1').DataTable({
      // bStateSave: true,
      // "fnStateSave": function (oSettings, oData) {
      //   localStorage.setItem('offersDataTables', JSON.stringify(oData));
      // },
      // "fnStateLoad": function (oSettings) {
      //     return JSON.parse(localStorage.getItem('offersDataTables'));
      // },
      // responsive: {
      //   details: {
      //     type: 'column'
      //   }
      // },
      "order": [0, "desc"],
      processing: true,
      serverSide: true,
      ajax: MODEL+'/list_data',
      // columnDefs: [{
      //     className: 'dtr-control',
      //     orderable: false,
      //     targets:   0
      // }],
      columns: [
        // { data: 'DT_RowIndex', orderable: false, searchable: false},
        // {
        //   "render": function (data, type, full, meta) {
        //         return "";
        //   },
        //   "title": "",
        //   "orderable": false,
        //   "searchable": false
        // },
        {
          data: 'id',
          name: 'id'
        },
        {
          data: 'game.name',
          name: 'Game'
        },
        {
          data: 'name',
          name: 'name'
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

  const eventPointTables_validation = (formData) => {
    $(".validation-popup").css('display','none');
    let event_id = $("#event_id").val();
    var call = ajaxCall('/'+ADMIN+'/'+MODEL+'/'+event_id+'/eventPointTables_validation', 'post', 'json', formData, []);
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

  const eventPointTables_update = (event_id) => {
    
    btn_disable(true,'save_btn','validating, Please Wait...');
    var formData1 = new FormData(document.getElementById('form'));
    if (eventPointTables_validation(formData1)) {
      btn_disable(true,'save_btn','saving, Please Wait...');
      var formData2 = formData1;
      formData2.append('_method','PUT');
      
      var call = ajaxCall('/'+ADMIN+'/'+MODEL+'/'+event_id+'/'+'eventPointTables_update', 'post', 'json', formData2, []);
      userAuth(call);
      if (call.status == 200) {
        let response = call.responseJSON;
        window.location.replace(response.result.next);
      }

    }
  }