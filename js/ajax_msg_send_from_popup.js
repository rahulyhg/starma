$(document).ready(function(){

      $('#send_msg').click(function(event){
        //alert('submitting...');
        event.preventDefault();

        var msg_data = {
          'text_body'         : $('#msg_sendie').val(),
          'other_user_id'     : $('input[name=other_user_id]').val(),
          'chart_id1'         : $('input[name=chart_id1]').val(),
          'chart_id2'         : $('input[name=chart_id2]').val(),
        };

        //alert(msg_data['text_body']);
      
        $.ajax({
            type      : 'POST',
            url       : 'chat/send_msg_from_profile.php',
            data      :  msg_data,
            dataType  : 'json',

        })
          .done(function(data){
            console.log(data);

            if(data == 'Empty') {
              //alert('success: ' + data);
              $('#msg_sent').hide();
              $('#send_message_area').show();
              $('#msg_label').text('Your Message is Empty');
            }
            else {
              $('#send_message_area').hide();
              $('#msg_sent').show();
              $('#msg_sent').html('<p>Message Sent!</p>');
              //alert(data);
             
               $('.pop').fadeOut(1700, function() {
                      $('#msg_sendie').val('');
                      $('#send_message_area').show();
                      $('#msg_sent').hide();
                      $('#msg_sent').html('');
                      $('#msg_label').text('New Message');
                  });
               //$('#msg_sendie').val('');
          
            } 

          })
          .fail(function(data){
              console.log(data);
              alert('failure: ' + data + msg_data['text_body']);
          });
        

      });
});

   /*         
            success   :  function(data){
                            alert('sucess: ' + data);
                          },
            error     :  function(data){
                              alert('failure' + data + msg_data['text_body']);
                          }
    */