$(document).ready(function(){
      $('#send-message-area').submit(function(event){
        //alert('submitting...');

        var msg_data = {
          'text_body'         : $('textarea[name=text_body]').val(),
          'other_user_id'     : $('input[name=other_user_id]').val(),
          'chart_id1'         : $('input[name=chart_id1]').val(),
          'chart_id2'         : $('input[name=chart_id2]').val()
        };

        //alert(msg_data['text_body']);
      
        $.ajax({
            type      : 'POST',
            url       : 'chat/send_msg_from_profile.php',
            data      :  msg_data,
            dataType  : 'json',
            success   :  function(data){
                            alert('sucess: ' + data);
                          },
            error     :  function(data){
                              alert('failure' + data + msg_data['text_body']);
                          }

        })
          //.done(function(data){
          //  console.log(data);

            //if(!data) {
              //alert('success: ' + data);
              //$('#msg_sendie').val('There was no text to send!');
            //}
            //else {
              //$('#send-msg-area').hide();
              //$('#msg_sent').show();
              //$('#msg_sent').html('<p>Message Sent!</p>');
              //alert(data.message);
            //} 

          //})
          //.fail(function(data){
          //    console.log(data);
          //    alert('failure: ' + data + msg_data['text_body']);
          //});
        event.preventDefault();

      });
    });