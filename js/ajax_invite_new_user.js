$(document).ready(function(){

      var $invite = $('#msg_sendie').val();

      $('.msg_send_invite').click(function(event){
        //alert('submitting...');
             
        var msg_data = {
          'first_name'        : $('#first_name_invite').val(),
          'last_name'         : $('#last_name_invite').val(),
          'their_name'        : $('#their_name_invite').val(),
          'email'             : $('#their_email_invite').val()
          'text_body'         : $('#msg_sendie_invite').val(),
          'sender_user_id'    : $('input[name=sender_user_id]').val(),  
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
            alert(data);
            /*
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
              //alert(data.message);
             
               $('.pop').fadeOut(1700, function() {
                      $('#msg_sendie').val($invite);
                      $('#send-message-area').show();
                      $('#msg_sent').hide();
                      $('#msg_sent').html('');
                      $('#msg_label').text('New Message');
                      $('#email_label').text('Email Address');
                      $('#email_invite').val('');
                  });
          
            } 
          */
          })
          .fail(function(data){
              console.log(data);
              alert('failure: ' + data + msg_data['text_body']);
          }); 

      event.preventDefault();

      });

    });