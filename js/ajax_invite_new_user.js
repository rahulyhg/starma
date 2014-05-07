$(document).ready(function(){
      $('#send-message-area').submit(function(event){
        //alert('submitting...');
             
        var msg_data = {
          'text_body'         : $('textarea[name=text_body]').val(),
          'other_user_id'     : $('input[name=other_user_id]').val(),
          'email'             : $('input[name=email]').val()
        };

        //alert(msg_data['text_body']);
      
        $.ajax({
            type      : 'POST',
            url       : 'chat/invite_new_user.php',
            data      :  msg_data,
            dataType  : 'json',

        })
          .done(function(data){
            console.log(data);

            if(data.errors) {
              //alert('success: ' + data);
              $('#msg_sent').hide();
              $('#send-message-area').show();
              if(data.errors.email) {
                $('#email_label').text(data.errors.email);
              } 
              else {
                $('#email_label').text('Email Address');
              }
              if(data.errors.text_body) {
                $('#msg_label').text(data.errors.text_body);
              }
              else {
                $('#msg_label').text('New Message');
              }
            }
            else {
              $('#send-message-area').hide();
              $('#msg_sent').show();
              $('#msg_sent').html('<p>Message Sent!</p>');
              //alert(data);
             
               $('.pop').fadeOut(1700, function() {
                      $('#msg_sendie').val('');
                      $('#send-message-area').show();
                      $('#msg_sent').hide();
                      $('#msg_sent').html('');
                      $('#msg_label').text('New Message');
                      $('#email_label').text('Email');
                  });
               //$('#msg_sendie').val('');
          
            } 

          })
          .fail(function(data){
              console.log(data);
              alert('failure: ' + data + msg_data['text_body']);
          }); 

      event.preventDefault();

      });

    });