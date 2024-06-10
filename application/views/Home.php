	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>OCR Readable DOCS</title>

		<!-- Add Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

		<style>
			/* Define your custom background gradient class */
			.custom-background-gradient {
				background-image: linear-gradient(white,lightblue);
			
			}
			.custome-font-size {
				font-size:20px;
				font-weight:bold;
			}
			.error{
				color: red;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row justify-content-center p-4" style="height: 70vh;">
				<div class="col-10">
				<form id="uploadDoc" method="post" action="#" enctype="multipart/form-data">
					<div class="card mb-4">
					<div class="card-header p-3" style="background: #1e4885;">
					<h5 class="font-weight-bolder custome-font-size" style="color:white;">Upload your documents here....</h5>
					</div>
						<div class="card-body">
							<div class="row">
								<div class="col">
									<label for="emirates-front">Emirates Front</label>
									<input type="file" class="form-control doc" id="emirates-front" name="emirates-front">
								</div>
								<div class="col">
									<label for="emirates-back">Emirates Back</label>
									<input type="file" class="form-control doc" id="emirates-back" name="emirates-back">
								</div>
								<div class="col">
									<label for="emirates-back">Prescriptions</label>
									<input type="file" class="form-control" id="prescriptions" name="prescriptions">
								</div>
							</div>
						</div>
					</div>
				</form>
				<form id="userForm" name="userForm" method="post" action="#">
					<div class="card">
					<div class="card-header p-3" style="background: #1e4885;">
					<h5 class="font-weight-bolder custome-font-size" style="color:white;">Please fill the form....</h5>
					</div>
						<div class="card-body">
							<div class="row">
								<div class="col mb-2">
									<label for="f-Name">First Name</label>
									<input type="text" class="form-control" id="fname" name="fname">
								</div>
								<div class="col">
									<label for="L-Name">Last Name</label>
									<input type="text" class="form-control" id="lname" name="lname">
								</div>
								
							</div>
							<div class="row">
								<div class="col mb-2">
									<label for="lName">Emirates ID</label>
									<input type="text" class="form-control" id="emirateNum" name="emirateNum">
								</div>
								<div class="col">
									<label for="nationality">Nationality</label>
									<select class="form-select" id="nationality" name="nationality">
										<option value="India">India</option>
										<option value="United Arab Emirates">United Arab Emirates</option>
										<option value="America">America</option>
										<!-- Add more options as needed -->
									</select>
								</div>
							</div>
							<div class="row">
							<div class="col mb-2">
								<label for="gender">Gender</label>
								<select class="form-select" id="gender" name="gender">
									<option value="F">Female</option>
									<option value="M">Male</option>
								</select>
							</div>
								<div class="col">
									<label for="dob">Date of Birth</label>
									<input type="date" class="form-control" id="dob" name="dob">
								</div>
							</div>
							<div class="text-end justify-content-end align-items-end">
								<button class="btn mt-2 px-5 mx-auto btn-lg" style="background: #1e4885; color: #fff;">Submit</button>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		

	<!-- Add Bootstrap JavaScript and jQuery -->
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
	<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>		
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.doc').change(function() {
                 // Get the selected file
        	var file = $(this)[0].files[0];

			// Check if a file was selected
			if (file) {
				// Create a FormData object to send the file
				var formData = new FormData();
				formData.append('imageFile', file);

				// Send an AJAX request to the CI controller
				$.ajax({
					url: 'OCR/uploadDocuments', // Replace with the actual URL of your CI controller
					type: 'POST',
					data: formData,
					processData: false, // Prevent jQuery from processing the data
					contentType: false, // Set the content type to false
					success: function(response) {
						// Handle the response from the controller
						var res = JSON.parse(response);
						if(res.documentData[0]['DocumentSubType']=='Front_Old')
						{
						var IDNumber =  res.documentData[0]['Data']['ID Number'];
						var Fullname = res.documentData[0]['Data']['Name'];
						var nameParts = Fullname.split(" ");
						var Fname = nameParts[0];
						var Lname = nameParts[nameParts.length - 1];
						if(Lname==""){var Lname = nameParts[nameParts.length - 2];}
						var nationality = res.documentData[0]['Data']['Nationality'];
						$('#fname').val(Fname);
						$('#lname').val(Lname);
						$("#nationality").val(nationality);
						$('#emirateNum').val(IDNumber);
						}
						else if(res.documentData[0]['DocumentSubType']=='Back_Old')
						{
						var dob = res.documentData[0]['Data']['Date of Birth'];
						var gender = res.documentData[0]['Data']['Sex'];
						$('#dob').val(dob);
						$('#gender').val(gender);
						console.log(dob)
						}
						if(res.documentData[0]['Errocode']=="106")
						{
							swal({
							title: 'Invalid Document',
							text: 'Please upload a file which is selected in Document Type!',
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#DD6B55',
							confirmButtonText: 'Ok',
							}).then(() => {
								document.getElementById('uploadDoc').reset();
							});
						}

					},
					error: function(xhr, status, error) {
						// Handle errors here
						console.error(xhr.responseText);
					}
				});
			}
            });

			$("#userForm").validate({
				rules: {
                fname: "required",
                lname: "required",
				gender: "required",
				dob: "required",
				nationality: "required",
                emirateNum: "required",
			},
            messages: {
                fname: "Please enter your Firstname",
				lname: "Please enter your Lastname",
				gender: "Please select your Gender",
				dob: "Please enter your date of birth",
				nationality: "Please select your Nati0nality",
				emirateNum: "Please enter your ID number",
            },
            submitHandler: function (form) {
                // Form is valid, proceed with AJAX submission
                var formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: 'OCR/saveUserData',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
						var res = JSON.parse(response);
						console.log(res);
						if(res.code==200) {
							window.location.href = "Thankyou";
						}
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        });
    </script>
	</body>

	</html>
