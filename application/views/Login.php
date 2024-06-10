<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">  
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login Form</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <style>
    .error{
        color:red;
        font-size:small;
        font-weight: normal;
    }  
  </style>
</head>

<body>

  <main class="bgtheme">
    <div class="container ">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-5">
            <div class="col-lg-4 col-md-4">
              <div class="card mb-3 px-3">

                <div class="card-body">

                <div class="alert alert-danger" role="alert" id="alert" style="display:none">
                 Invalid Username or Password
                 </div>
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4"><b>Welcome</b></h5>
                    <p class="text-center small"> Sign in the entering the information below.</p>	
                  </div>

                  <form class="row g-3 needs-validation" novalidate id="login_Form" method="post">
                    <div class="col-12">
                      <label for="yourUsername" class="form-label"><b>Username</b></label>
                        <input type="text" name="username" class="form-control" id="username" required >
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label"><b>Password</b></label>
                      <input type="password" name="password" class="form-control" id="password" required >
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="submit" id="submit" type="submit">Login</button>
                    </div>
                    <!-- <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="">Create an account</a></p>
                    </div> -->
                  </form>

                </div>
              </div>


            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

                <!-- </a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
<script type="text/javascript">
 $(document).ready( function()
{
  var validate1 = $('form[id="login_Form"]').validate({
  errorClass: 'error',
  rules: {
    username:"required",
    password:
    {
      required: true,
    },                                                       

    },
  messages:{
  username: "Please Enter Your username",
  password:"Please Enter your password",

     }, 
      submitHandler: function(form) {

            var form = $('#login_Form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "Login/ValidateUser",
                type: 'POST',
                cache: false,
                data: data,
                async: false,
                contentType: false,
                processData: false,
               success: function(response) {
                 var data = JSON.parse(response);
				 if(data.code==200)
				 {
					window.location.href = "OCR";
				 }
				 else
				 {
					$("#alert").show();
					setTimeout(function () {
						$("#alert").hide(); // Hide the element after 2 seconds
					}, 2000);
					// alert('something went wrong try again');
				 }
                  }
            });
        }      
});
});
</script> 
</body>
</html>
