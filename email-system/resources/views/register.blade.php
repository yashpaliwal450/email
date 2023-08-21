
<html>
<head>
    <title>Email System</title>
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
    <script>
        $().ready(function () {
            $("#signupForm").validate({
            rules: {
                firstname: {
                    required: true,
                    minlength: 2 
                    
                    },
                lastname: {
                    required: true,
                    minlength: 2 
                    
                    },
                age: {
                    required: true,
                    number: true,
                    min: 18,
                    },
                
                email: {
                    required: true,
                    email: true
                },
                password: {
                        required: true,
                        minlength: 5
                    },
                confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                
            },
            messages: {
                firstname: {
                    required: " Please enter a first name",
                    minlength:
                    " Your first name must consist of at least 2 characters"
                    },
                    lastname: {
                    required: " Please enter a last name",
                    minlength:
                    " Your last name must consist of at least 2 characters"
                    },
                email: {
                    required: " Please enter a email",
                    email: "Please enter email in proper formate"
                    },
                age: {
                    required: "Please enter your age",
                    number: "Please enter your age as a numerical value",
                    min: "You must be at least 18 years old",
                    
                    },
                }
            });
            $('#submitBtn').on('click',function(e) {
              var formData = new FormData($('#signupForm')[0]);
              $.ajax({
                
                url: "http://3.24.179.107:8000/api/addUsers", // 
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                },
                success: function(response) {
                if(response.success == true){
                    console.log(response);
                    window.location.replace("http://3.24.179.107:8000/api/home","self");
                }
                },
                error: function(error) {
                    $("#response").html("Email Id exists");
                    setTimeout(function() {
                            $("#response").fadeOut();
                        }, 3000);
                    console.log(error); 
                }
              });
            });


        });
            
    </script>

    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-dark"
        style="background-color: #ff9933">
        <div>
            <a id="home" href="{{route('home')}}" class="navbar-brand">Email System</a>
        </div>
    </nav>
</header>
<br>
<div >


<div class="container col-md-8">
    <div class="card">
        <div class="card-body">
            <span id="response"></span>
            <h2 style="text-align:center; color:pink;">Update User Data</h2><br/>
            <form name='signupForm' id="signupForm"  enctype="multipart/form-data">    
            <div style="text-align:center;">
            <table>

                <div class = "form-group">
                    <tr><td>
                <label for="firstname">First Name:</label>
                </td><td>
                        <input type="text" name="firstname" id="firstname"  > 
                </td></tr>
                </div>
                
                <div class = "form-group">
                    <tr><td>
                <label for="lastname">Last Name:</label>
                </td><td>
                        <input type="text" name="lastname" id="lastname"  > 
                </td></tr>
                </div>

                <div class = "form-group">
                <tr><td>
                <label for="email">E-mail: </label>
                </td><td>
                <input type="text" name="email" id="email" >
                </td></tr>
                </div>
                <div class = "form-group">
                <tr><td>
                <label for="password">Password: </label>
                </td><td>
                <input type="password" name="password" id="password" >
                </td></tr>
                </div>

                <div class = "form-group">
                <tr><td>
                <label for="confirm_password">Confirm Password: </label>
                </td><td>
                <input type="password" name="confirm_password" id="confirm_password" >
                </td></tr>
                </div>
                <div class = "form-group">
                <tr><td>
                <label for="age">AGE:</label>
                </td><td>
                <input type="text" name="age" id="age" >
                </td></tr>
                </div>
                
                <div class = "form-field">
                <tr><td>
                        <label for="country">Choose your Country:</label>
                        </td><td>
                        <select name="country" id="country">
                        <option value="India">India</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="US">US</option>
                        </select>
                        </td></tr>
                </div>
                <tr><td>
                
                    <button type="button" id ="submitBtn" class="btn btn-success">Register</button>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
                    <button type="Reset" class="btn btn-success">Reset</button>
                </td></tr>
            </table>
            </div>
            </form>

        </div>
    </div>
</div>



</body>
</html>
