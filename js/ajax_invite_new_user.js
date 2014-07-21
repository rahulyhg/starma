$(document).ready(function(){

      var $invite = $('#msg_sendie').val();

      $('.msg_send_invite').click(function(event){
        //alert('submitting...');
        event.preventDefault();
             
        var msg_data = {
          'first_name'        : $('#first_name_invite').val(),
          'last_name'         : $('#last_name_invite').val(),
          'their_name'        : $('#their_name_invite').val(),
          'email'             : $('#their_email_invite').val(),
          'text_body'         : $('#msg_sendie_invite').val(),
          'sender_user_id'    : $('input[name=sender_user_id]').val()  
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
            //alert(data.errors.first_name + ', ' + data.errors.last_name + ', ' + data.errors.their_name + ', ' + data.errors.email);
            
            if(data.errors) {
              //alert('success: ' + data);
              $('#msg_sent').hide();
              $('#send-message-area').show();
              if(data.errors.first_name){
                $('#first_name_error').text(data.errors.first_name);
              }
              if(data.errors.last_name){
                $('#last_name_error').text(data.errors.last_name);
              }
              if(data.errors.their_name){
                $('#their_name_error').text(data.errors.their_name);
              }
              if(data.errors.email) {
                $('#their_email_error').text(data.errors.email);
              } 
              if(data.errors.sender_user_id) {
                $('#sender_id_error').text(data.errors.sender_user_id);
              }
            }
            else {
              $('#send-message-area').hide();
              $('#msg_sent').show();
              $('#msg_sent').html('<p>Invite Sent!</p>');
              //alert(data.message);
             
               $('.pop').fadeOut(1700, function() {
                      $('#msg_sendie').val($invite);
                      $('#send-message-area').show();
                      $('.invite_error').hide().html('');
                      $('#msg_sent').hide();
                      $('#msg_sent').html('');
                      $('#first_name_invite').val('first name');
                      $('#last_name_invite').val('last name');
                      $('#their_name_invite').val('name');
                      $('#their_email_invite').val('email');
                  });
          
            } 
          
          })
          .fail(function(data){
              console.log(data);
              alert('failure: ' + data + msg_data['text_body']);
          }); 

    

      });

    });