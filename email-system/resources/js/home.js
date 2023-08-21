$().ready(function () {
            
    $("#signupForm").validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        password: {
                required: true,
            },
    },
       // In 'messages' user have to specify message as per rules
    messages: {
        email: {
            required: " Please enter a email",
            email: "Please enter email in proper formate"
            },
        password:{
            required: "Please enter Password"
        }
        }
    });

    $('#submitBtn').on('click',function(e) {
      var formData = new FormData($('#signupForm')[0]);
      $.ajax({
        
        url: "http://127.0.0.1:8000/api/Login", // Replace with your form submission URL
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {    
            
        },
        success: function(response) {
            if(response.success==true){
            localStorage.setItem("user_token",response.access_token);
            console.log(response);
            window.location.href="http://127.0.0.1:8000/api/inbox";
            }
            else{
                console.log(error);
            }
            
        },
        error: function(error) {    
            console.log(error);
        }
      });
    });

    $('#addUserForm').on('click',function(e) {
        window.location.href="http://127.0.0.1:8000/api/addUserForms";
    
    
    });
});