@extends('layouts.app')
@section('content')
<div class="row chat-row personalChat">
    <div class="chat-content">
        <ul class="chat-ul"></ul>
    </div>

    <div class="chat-section">
        <div class="chat-box">
            <small class="isTyping text-muted"></small>
            <div class="row mb-2">
                <div class="col-6">
                    <div class="fileBox"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- <div class="notification"></div> -->

                    <div class="form-group">
                        <label>Title</label>
                        <input type="textbox" name="title" id="title" class="chat-input form-control" contenteditable=""/>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="chat-input form-control" id="description" cols="30"></textarea>
                    </div>
                    
                    <label class="btn btn-primary position-relative"><input type="file" name="icon" class="fileInput" id="icon" /> File</label>
                </div>
                <div class="col-12">
                    <label class="btn btn-primary position-relative sendMessage">Send</label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<!-- JavaScript Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
<!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
<script>

    var ip_address = "{{ env('APP_HOST') }}";
    var socket_port = "{{ env('SOCKET_PORT') }}";
    var base_url = "{{ env('BASE_URL') }}"
    // console.log(ip_address + ':' + socket_port);
    let socket = io(ip_address + ':' + socket_port);

    $(function() {
        let sendMessageBtn = $('.personalChat .sendMessage');
        // let chatUl = $('.personalChat .chat-ul');
        let fileInput = $('.personalChat .fileInput');
        let messages = [];

        // let browser = fnBrowserDetect();
        // let IsTyping = false;
        let uploadIds = [];

        // if (browser == "firefox") {
        //     var from_user_id = 3;
        //     var to_user_id = 1;
        // } else {
        //     var from_user_id = 1;
        //     var to_user_id = 3;
        // }

        sendMessageBtn.click(function(e) {
            sendMessage();
        })

        function sendMessage() {
            let title = $('.personalChat #title').val().trim();
            let description = $('.personalChat #description').val();
            let icon = '';

            let socketData = {
                'title': title,
                'message': description,
                'icon': icon,
            }
            let result = socket.emit('new_notification', socketData);
            // console.log(result);
        }

        fileInput.change(async function() {
            let file = this.files[0];

            // console.log(request);
            // return false;

            const form = new FormData();
            form.append('from_user_id', from_user_id);
            form.append('file', file);

            // console.log(form.from_user_id);
            // return false;

            axios({
                    method: "post",
                    url: base_url + '/api/message/uploadChatFile',
                    data: form,
                    headers: {
                        'Accept': 'application/json',
                        'domain': domain,
                        'Authorization': 'Bearer ' + token,
                        // 'content-type': 'application/x-www-form-urlencoded',
                        // 'Content-Type': `multipart/form-data; boundary=${form._boundary}`
                        // 'Content-Type': `multipart/form-data;`
                    }
                }).then(function(response) {
                    //handle success
                    if (response.status == 200) {
                        // uploadIds = [];
                        // console.log(response.data.result.uploads);
                        let uploadData = response.data.result.uploads;

                        let imgHtml = '<div><img src="' + uploadData.fullPath + '" width="100"/></div>';
                        $('.fileBox').html(imgHtml);
                        uploadIds.push(uploadData);
                    }
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                    console.log(response.response.status);
                });
            // return false;

            // socket.emit('fileToServer', domain, token, from_user_id, file);

            //     // var reader = new FileReader();
            //     // reader.onload = function (e) {
            //     //     console.log('rrr');
            //     //     let imgHtml = '<img src="'+e.target.result+'" width="150"/>';
            //     //     chatInput.html('fff');
            //     //     $('#blah').attr('src', e.target.result).width(150).height(200);
            //     // };

            //     console.log(fileList);
            //     //TODO do something with fileList.
            // }

            // let fileInput = $('.fileInput');
            // fileInput.on('change',function(){
            //     console.log(this);
        })

        socket.on('show_notification', (data) => {
            console.log(data);
        });

        socket.on('new_notification', (user_id) => {
            $('.isTyping').html(user_id + ' is typing ...');
        });
        socket.on('blurPersonalMsgToClient', (user_id) => {
            $('.isTyping').html('');
        });

    });
</script>
@endsection