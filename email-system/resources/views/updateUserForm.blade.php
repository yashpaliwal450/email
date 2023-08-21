
<html>
<head>
    <title>Email System</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
            $().ready(function () {
            $.ajax({
                url:"http://3.24.179.107:8000/api/updateUserForm",
                type: "GET",
                headers:{'Authorization': localStorage.getItem('user_token')},
                success:function(data){
                if(data.success == true){
                    if(data.photo!=null){
                        $("#profileimg").append("<img alt='Logo' src=/"+data.photo.file_path+" id ='userPhoto' class='rounded-circle' width='50' height='50'>");
                    }
                    else{
                        var name = data.user.first_name.substring(0, 1)+data.user.last_name.substring(0,1)
                        $("#userName").html(name);
                    }
                    $("#firstname").val(data.user.first_name)
                    $("#lastname").val(data.user.last_name)
                    $("#age").val(data.user.age)
                    // $("#image").val(data.photo.file_name)
                }
                },error: function(error) {
                    console.log(error); 
                    window.location.href="http://3.24.179.107:8000/api/home";
                    }
            });

            $('#logout').on('click',function(e) {
                $.ajax({
                url:"http://3.24.179.107:8000/api/logout",
                headers: {'Authorization': localStorage.getItem('user_token')},
                success:function(response){
                    if(response.success == true){
                    localStorage.removeItem('user_token');
                    window.open("/home","self");
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
                window.location.href="http://3.24.179.107:8000/api/updateUserFormView";
            });

                $('#submitt').on('click',function(e) {
                var formData = new FormData($('#signupForm')[0]);
                $.ajax({
                    
                    url: "http://3.24.179.107:8000/api/updateUser", // Replace with your form submission URL
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {'Authorization': localStorage.getItem('user_token')},
                    success: function(response) {
                    // Handle the success response (optional)
                    if(response.success == true){
                        console.log(response);
                        window.location.href="http://3.24.179.107:8000/api/inbox";
                    }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
                });
                $('#inbox').on('click',function(e) {
                window.location.href="http://3.24.179.107:8000/api/inbox";
                });
                $('#sent_mail').on('click',function(e) {
                window.location.href="http://3.24.179.107:8000/api/sent_mail_page";
                });
            });
                
        </script>

    </head>

    <body>

    <header>
        <nav class="navbar navbar-expand-md navbar-dark "
            style="background-color: #ff9933">
            <div class="collapse navbar-collapse" id="navbarNav">
            <div>
                <a href="http://3.24.179.107:8000/api/inbox" class="navbar-brand">Email System</a>
            </div>
                <div class="ml-auto">
                    <a id="update" href="" class="navbar-brand rounded-circle">
                    
                    <div id="profileimg">
                    </div>
                    
                    <div class="rounded-circle" id="userName">
                        
                    </div>
                    
                    </a>
                    <a id="logout" href="" class="navbar-brand">logout</a>
                </div>
            </div>
        </nav> 
</header>
<br>



<div class="container col-md-8">
    <div class="card">
        <div class="card-body">
            <h2 style="text-align:center; color:pink;">Update User Data</h2><br/>
            <form name='signupForm' id="signupForm"  enctype="multipart/form-data">
            @csrf    
            <div style="text-align:center;">
            <table>
                <div class = "form-group">
                    <tr><td>
                <label for="firstname">First Name:</label>
                </td><td>
                        <input type="text" name="firstname" id="firstname" value="" > 
                </td></tr>
                </div>
                <div class = "form-group">
                    <tr><td>
                <label for="lastname">Last Name:</label>
                </td><td>
                        <input type="text" name="lastname" id="lastname" value="" > 
                </td></tr>
                </div>
                
                <div class = "form-group">
                <tr><td>
                <label for="age">AGE:</label>
                </td><td>
                <input type="text" name="age" id="age" value="" >
                </td></tr>
                </div>
                
                <div class = "form-group">
                <tr><td>
                <label for="image">Image: </label>
                </td><td>
                <input type="file" name="image" id="image" >
                </td></tr>
                </div>

                <tr><td>
                
                    <button type="button" id ="submitt" class="btn btn-success">Update</button>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
                    
                </td></tr>
            </table>
            </div>
            </form>

        </div>
    </div>
</div>



</body>
</html>
