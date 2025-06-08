<!doctype html>
<html lang="en">
  <head>
  
  <!--This line is necessary to load Google Recaptcha on the page-->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	
<!--This script does the basic checking on fields to ensure all fields are completed -->	
<script>
        function validateForm() {
            var first_name = document.forms["myForm"]["first_name"].value;
			var last_name = document.forms["myForm"]["last_name"].value;
            var email = document.forms["myForm"]["email"].value;
            var companyName = document.forms["myForm"]["company_name"].value;
            var industry = document.forms["myForm"]["industry"].value;

            if (fullName === "" || email === "" || companyName === "" || industry === "") {
                alert("All fields are required");
                return false;
            }
        }
    </script>
<!--***EDIT HERE***--->
    <title>***PLEASE CHANGE*** Delldata Mobile - Client Free 14-Day Trial Signup Form</title>
  </head>
 <body>
  
		<div class="container">
				<div class="w-50 mx-auto">
					<div class="row">
						<h4 class="text-center">Free trial signup form - Delldata Mobile</h4>
					</div>
				  <form name="myForm" id="contactForm" action="process-signup.php" method="post" onsubmit="return validateForm()">
						<div class="row">
							<div class="col col-lg-4">
								<span id="first_name">First Name:</span>
							</div>
							<div class="col col-lg-4">
								<input type="text" name="first_name" required autocomplete="on">
							</div>
						</div>
					
						<div class="row">
							<div class="col col-lg-4">
								<span id="last_name">Last Name:</span>
							</div>
							<div class="col col-lg-4">
								<input type="text" name="last_name" required autocomplete="on">
							</div>
						</div>
					
						<div class="row">
							<div class="col col-lg-4">
								<span id="email">Email:</span>
							</div>
							<div class="col col-lg-4">
								<input type="email" name="email" required autocomplete="on">
							</div>
						</div>
					
						<div class="row">
							<div class="col col-lg-4">
								<span id="company_name">Company Name:</span>
							</div>
							<div class="col col-lg-4">	
								<input type="text" name="company_name" required autocomplete="on">
							</div>
						</div>
					
						<div class="row">
							<div class="col col-lg-4">
								<label for="industry">Industry:</label>
							</div>
							<div class="col col-lg-4">	
								<select name="industry" id="industry" required>
									  <option value="Administration">Administration</option>
									  <option value="Agriculture">Agriculture</option>
									  <option value="Construction">Construction</option>
									  <option value="FieldService">FieldService</option>
									  <option value="Finance">Finance</option>
									  <option value="General">General</option>
									  <option value="Government">Government</option>
									  <option value="Healthcare">Healthcare</option>
									  <option value="Hospitality">Hospitality</option>
									  <option value="Insurance">Insurance</option>
									  <option value="ITTelecoms">IT Telecoms</option>
									  <option value="Landscaping">Landscaping</option>
									  <option value="Manufacturing">Manufacturing</option>
									  <option value="RealEstate">Real Estate</option>
									  <option value="Safety">Safety</option>
									  <option value="Sales">Sales</option>
									  <option value="Security">Security</option>
									  <option value="Training">Training</option>
									  <option value="Transportation">Transportation</option>
									  <option value="Utilities">Utilities</option>
									</select>
							</div>
						</div>

						<input type="hidden" id="timezone" name="timezone" value="GMT Standard Time">
							<?php
								$utcDateTime = gmdate('Y-m-d H:i:s');
							?>	
					
						<input type="hidden" id="datetime" name="datetime" value="<?php echo $utcDateTime;?>">
					
					<!---***EDIT HERE***-replace the value in data-sitekey below with your Recaptcha Site Key-->
						<div class="row">
							<div class="col col-lg-12">
								<div class="g-recaptcha" data-sitekey="6LdSulkrAAAAAOObleT9ct036Dt3G_2udD-AUFcM"></div>
							</div>
						</div>
					
						<div class="row">
							<div class="col col-lg-12">
								<button type="submit" id="submitButton" class="btn btn-primary text-center">Submit</button>
							</div>
						</div>
					</form>
				</div>
		</div>  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!--The script below does the Recaptcha check and then only submits the form to your API once it has passed Recaptcha-->
	
	<script>
			$(document).ready(function () {
				// Attach a click event to the submit button
				$("#submitButton").on("click", function () {
					// Validate reCAPTCHA
					var recaptchaResponse = grecaptcha.getResponse();

					if (recaptchaResponse.length === 0) {
						alert("Please complete the reCAPTCHA verification.");
					} else {
						// Perform additional client-side validation if needed
						// Submit the form
						//alert("Submitting the form"); //Edit this out once you're happy everything is working
						//console.log("Submitting the form"); //Edit this out once you're happy everything is working
						$("#contactForm").submit();
					}
				});
			});
	</script>

  </body>
</html>
