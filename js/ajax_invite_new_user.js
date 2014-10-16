$(document).ready(function(){

      //var $invite = $('#msg_sendie').val();

      $('#send_invite').click(function(event){
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
              if(!data.errors.first_name){
                $('#first_name_error').text('');
              }
              if(data.errors.last_name){
                $('#last_name_error').text(data.errors.last_name);
              }
              if(!data.errors.last_name){
                $('#last_name_error').text('');
              }
              if(data.errors.their_name){
                $('#their_name_error').text(data.errors.their_name);
              }
              if(!data.errors.their_name){
                $('#their_name_error').text('');
              }
              if(data.errors.email) {
                $('#their_email_error').text(data.errors.email);
              } 
              if(!data.errors.email) {
                $('#their_email_error').text('');
              } 
              if(data.errors.sender_user_id) {
                $('#sender_id_error').text(data.errors.sender_user_id);
              }
              if(!data.errors.sender_user_id) {
                $('#sender_id_error').text('');
              }
            }
            if(data.success) {
              $('#send-message-area').hide();
              $('#invite_sent').show();
              $('#invite_sent').html('<p>Invite Sent!</p>');
              //alert(data);
              $('.pop_invite').fadeOut(1700, function() {
                      $('#msg_sendie_invite').val('');
                      $('#their_name_invite').val('');
                      $('#their_email_invite').val('');
                      $('#send-message-area').show();
                      $('#invite_sent').hide();
                      $('#invite_sent').html('');
                      $('.invite_error').text('');
                  });
            } 
          
          })
          .fail(function(data){
              console.log(data);
              alert('failure: ' + data + msg_data['text_body']);
          }); 

    

      });

    });