<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Email System</title>
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
        <script src=
            "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
        </script>
        <script src=
            "https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js">
        </script>
        <script src=
            "https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js">
        </script>
        <script src=
            "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
        </script>
        <!-- Latest compiled JavaScript -->
        <script src=
            "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
        </script>
        <script >
            $().ready(function () {
            if(localStorage.getItem("user_token")!=null){
                window.location.href="http://127.0.0.1:8000/api/inbox";
            }
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
        </script>

    </head>
<body>
    <header>
    <nav class="navbar navbar-expand-md navbar-dark " style="background-color: #ff9933">
        <div class="collapse navbar-collapse" id="navbarNav">
            <div>
                    <a href="{{route('home')}}" class="navbar-brand">Email System</a>
            </div>
        </div>
    </nav> 
    </header>
    <section class="">

        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 vh-100 " style="background-color:cyan;">
            <br>
            <img src="data:image/jpeg;base64,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" width="590" height="500">
            </div>
            <div class="col-lg-6 vh-100 " style="background-color:powderblue;">
            <div >


<div class="container col-md-8">
    <div class="card" style="text-align:center; top:170px;">
        <div class="card-body md-5" >
        
            <h2 style="text-align:center; color:pink;">Login</h2><br/>
            
            <table>
            <form name='signupForm' id="signupForm">   
            <div style="text-align:center;">
            @csrf
                <div class = "form-group">
                <tr><td>
                <label for="email">E-mail: </label>
                </td><td>
                <input id="email" class="block mt-1 w-full" type="email" name="email" class="form-control" required />
                </td></tr>
                </div>

                <div class = "form-group">
                <tr><td>
                <label for="password">Password:</label>
                </td><td>
                <input id="password" class="block mt-1 w-full" type="password" name="password"  class="form-control" required/>
                </td></tr>
                </div>
              
                <tr><td></td>
                </tr>
                <tr><td></td>
                </tr>
                <tr><td></td>
                </tr>
                <tr><td></td>
                </tr>
                <tr><td></td>
                </tr>
                <tr><td></td>
                </tr>
                <tr ><td></td>
                <td>
                    <button type="button" id ="submitBtn" class="btn btn-success">Login</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
            </form>
            
            <button class="btn btn-success" id="addUserForm" >Register</button>
            </td></tr>
            </table>   
            
            @isset($err)
            <div class="alert alert-danger mt-3">
          Wrong Credentials
        </div>
              @endisset
        </div>
    </div>
</div>
    </div>
  </div>
</div>

</section>
     </body>
</html>