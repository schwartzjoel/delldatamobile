<?php

//***EDIT HERE*************IMPORTANT!!!***************************
//Change the details below to match your credentials
$apiEndpoint_company = 'https://app.delldatamobile.com/api/v2/company';
$apiEndpoint_user = 'https://app.delldatamobile.com/api/v2/user';

//Check the knowledgebase article for instructions on how to get your integration key - https://support.appenate.com/support/solutions/articles/1000000390-organization-setup
$integration_key = '574ab77238c04cea85f48b0974f5a588';
$vendor_id = '88199';
$support_user_email = "support@delldatamobile.com";
$notification_email = "support@delldatamobile.com";
//***************************************************

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $company_name = $_POST["company_name"];
    $industry = $_POST["industry"];
	$full_name = '$first_name $last_name';
	
	//Set account retire date to be 14 days from time submission received
	// Get the current date and time
	$currentDate = new DateTime();

	// Add 14 days to the current date
	$currentDate->add(new DateInterval('P14D'));

	// Format the result as a string
	$RetireDate = $currentDate->format('Y-m-d H:i:s');
	
    // Prepare data for the JSON request
    $company_data = array(
        "Name" => $company_name,
		"Description" => $company_name,
        "email" => $email,
        "industry" => $industry,
		"RetireDate" => $RetireDate,
		 "FillRepeatRows" => false,
		 "RerouteResetEmails" => false,
		 "WebFormTransactionLimit" => 0,
		 "PremiumUserLimit" => 5,
		 "StandardUserLimit" => 5,
		 "EdgeUserLimit" => 0,
		 "UserLimit" => 10,
		"AddSupportUser" => true,
		"SupportUserEmail" => $support_user_email,
		"CopyCustomIcons" => false,
		"IntegrationKey" => $integration_key,
		"VendorId" => $vendor_id		
    );
	
	// Convert the data to JSON format	
	$company_jsonData = json_encode($company_data);
	
	//Default Company API headers
    $header = array();
		$header[] = 'Accept: application/json';
		$header[] = 'Content-type: application/json';
		$header[] = 'X-API-Key: $integration_key';
		
	//Default USER API headers
    $user_header = array();
		$user_header[] = 'Accept: application/json';
		$user_header[] = 'Content-type: application/json';
		$user_header[] = 'X-API-Key: $company_integrationkey';	

		//Create Company - Sending a POST request to API
		$company_ch = curl_init($apiEndpoint_company);
					curl_setopt($company_ch, CURLOPT_POST, 1);
					curl_setopt($company_ch, CURLOPT_POSTFIELDS, $company_jsonData);
					curl_setopt($company_ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($company_ch, CURLOPT_HTTPHEADER, $header);

					//Get the HTTP response code from the API
					$company_httpCode = curl_getinfo($company_ch, CURLINFO_RESPONSE_CODE);
					
					$company_apiResponse = curl_exec($company_ch);
					
					// Decode the JSON response
						$decodedResponse = json_decode($company_apiResponse, true);
						
					//Get newly created company ID for use in User API call below
					$company_id = $decodedResponse['Company']['Id'];
					$company_integrationkey = $decodedResponse['Company']['IntegrationKey'];
					
					if ($company_apiResponse === false) {
						 echo "Error sending POST request to the API: " . curl_error($company_ch);
					 } else {		 
						 //After company is successfully created - create user
						$user_data = array(
							  "Type" => "Premium",
							  "FirstName" => $first_name,
							  "LastName" => $last_name,
							  "Email" => $email,
							  "LoginId" => $email,
							  "WebsiteRole" => "EnterpriseAdmin",
							  "DoNotEmail" => false,
							  "UseNames" => false,
							  "UseExternalIds" => false,
							  "CompanyId" => $company_id,
							  "IntegrationKey" => $company_integrationkey
						);
						
						//Convert the data to JSON format	
						$user_jsonData = json_encode($user_data);

						//Create User - Sending a POST request to API
						$user_ch = curl_init($apiEndpoint_user);
						curl_setopt($user_ch, CURLOPT_POST, 1);
						curl_setopt($user_ch, CURLOPT_POSTFIELDS, $user_jsonData);
						curl_setopt($user_ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($user_ch, CURLOPT_HTTPHEADER, $user_header);

							//Get the HTTP response code from the API
							$user_httpCode = curl_getinfo($user_ch, CURLINFO_RESPONSE_CODE);
							
							$user_apiResponse = curl_exec($user_ch);

							// Subject of the email
							$subject = 'Company and user created successfully!';

							// Message body with HTML content
							$mail_message = "
							<html>
							<head>
							  <title>API triggers completed successfully</title>
							</head>
							<body>
							  <h1>API Connection Successful</h1>
							  <p>Company created: {$company_name}</p>
							  <p><h2>User Details:</h2></p>
							  <p>Full Name: {$first_name} {$last_name}</p>
							  <p>Industry: {$industry}</p>
							  <p><h3>This trial is set to retire on {$RetireDate}</h3></p>
							  <p>The Company API Response is below:</p>
							  <p>{$company_apiResponse}</p><br><br>
							  <p>The User API Response is below:</p>
							  <p>{$user_apiResponse}</p>
							  <p>Thank you for using our services!</p>
							</body>
							</html>
							";

							// Additional headers for the email
							$mail_headers = 'MIME-Version: 1.0' . "\r\n";
							$mail_headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

							// Use the mail() function to send the email
							$mailResult = mail($notification_email, $subject, $mail_message, $mail_headers);

							// Check if the email was sent successfully
							if ($mailResult) {
								echo 'Thank you! Your signup was successful. Please check your email for further instructions.';
							} else {
								echo 'Error sending email. Please check your mail configuration.';
							}
					 }
					
					 curl_close($company_ch);
					 curl_close($user_ch);
					 
					 //Uncomment the code below for help with troubleshooting
					 
					 // echo "The response code from the Company API is: ";
					 // echo $company_httpCode;
					 // echo "<br><br>";
					// var_dump($company_apiResponse);
					// echo "<br><br>";
					// echo "Company ID = ".$company_id;
					// echo "<br><br>";
					// echo "Company Integration Key = ".$company_integrationkey;
					// echo "<br><br>"; 
					 // echo "The response code from the User API is: ";
					 // echo $user_httpCode;
					 // echo "<br><br>";
					// var_dump($user_apiResponse);
}
?>
