$().ready(function () {
    $.ajax({
      url:"http://127.0.0.1:8000/api/dashboardData",
      type: "GET",
      headers:{'Authorization': localStorage.getItem('user_token')},
      success:function(data){
        if(data.success == true){
            console.log(data);
            if(data.photo!=null){
              $("#profileimg").append("<img alt='Logo' src=/"+data.photo.file_path+" id ='userPhoto' class='rounded-circle' width='50' height='50'>");
            }
            else{
              var name = data.user.first_name.substring(0, 1)+data.user.last_name.substring(0,1)
              $("#userName").html(name);
            }
            $.each(data.emails.data, function (key, value) {
              $("#tblMail").append("<tr class='clickable-row' data-href=http://127.0.0.1:8000/api/mail_view?id="+value.email_id+"><td> By:"+value.email+"</td><td>" + value.body  +"</td><td>" +value.subject  +"</td></tr>");
              
            });
            $('.clickable-row').on('click', function() {
                  window.location.href= $(this).attr('data-href');
              });
              
        }
      },error: function(error) {
            console.log(error); 
            window.location.href="http://127.0.0.1:8000/api/home";
          }
    });

    $('#logout').on('click',function(e) {
      $.ajax({
        url:"http://127.0.0.1:8000/api/logout",
        headers: {'Authorization': localStorage.getItem('user_token')},
        success:function(response){
          if(response.success == true){
            localStorage.removeItem('user_token');
            window.open("http://127.0.0.1:8000/api/home","self");
          }
          else{
            console.log(response);
          }
        }
        ,error: function(error) {
            console.log(error); // Log the error for testing purposes
            // You can show error messages or update the UI here
          }
      });
    });

    $('#update').on('click',function(){
      window.location.href="http://127.0.0.1:8000/api/updateUserFormView";
    });

      $('#submitBtn').on('click',function(e) {
        var formData = new FormData($('#emailForm')[0]);
        $.ajax({
          
          url: "http://127.0.0.1:8000/api/send_mail", // Replace with your form submission URL
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          headers: {'Authorization': localStorage.getItem('user_token')},
          success: function(response) {
            if(response==1){
              console.log(response);
              $('#mymodal').modal('hide');
              $("#response").html("mail sent successfully");
              setTimeout(function() {
                        $("#response").fadeOut();
                    }, 3000); 
            }
            // Log the response for testing purposes
            // You can show success messages or update the UI here
          },
          error: function(error) {
            $('#mymodal').modal('hide');
            $("#response").html("Wrong Email Id");
            setTimeout(function() {
                      $("#response").fadeOut();
                  }, 3000);
            console.log(error); // Log the error for testing purposes
            // You can show error messages or update the UI here
          }
        });
      });
      $('#inbox').on('click',function(e) {
        window.location.href="http://127.0.0.1:8000/api/inbox";
      });
      $('#sent_mail').on('click',function(e) {
        window.location.href="http://127.0.0.1:8000/api/sent_mail_page";
      });
  });