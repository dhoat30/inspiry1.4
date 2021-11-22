<?php
//routes

add_action("rest_api_init", "email_route");

function email_route() {
    // send email to trade professional
    register_rest_route("inspiry/v1/", "professional-email", array(
        "methods" => "POST",
        "callback" => "professionalEmail"
    ));
	
	 // send email for join trade form
    register_rest_route("inspiry/v1/", "join-trade-email", array(
        "methods" => "POST",
        "callback" => "joinTradeEmail"
    ));

}

// send email to trade professional 
function professionalEmail($data) {
    $name = sanitize_text_field($data["name"]);
    $email = sanitize_text_field($data["email"]);
    $phone = sanitize_text_field($data["phone"]);
    $message = sanitize_text_field($data["message"]);
	$emailTo=sanitize_text_field($data["emailTo"]);
    $formName = "Enquiry Form";

		$name = "\n Name: $name";
		$headers = 'From: '.$email;
		$email = "\n Email: $email";
		$message = " \n Message: $message";
		$phone = " \n Phone: $phone";


		$msg = "Inspiry $formName \n\n $name $email $phone $message";

		$to = $emailTo;
		$sub = $formName;
		if(mail($to, $sub, $msg, $headers)){
			return 200;
		}
		else { 
		return 400; 
		}
		}

// send data of join trade form
function joinTradeEmail($data) {
    $name = sanitize_text_field($data["name"]);
    $email = sanitize_text_field($data["email"]);
    $phone = sanitize_text_field($data["phone"]);
	$company= sanitize_text_field($data["company"]);
	$website = sanitize_text_field($data["website"]);
    $message = sanitize_text_field($data["message"]);
	$emailTo=sanitize_text_field($data["emailTo"]);
	
    $formName = "Join Trade Form";

		$name = "\n Name: $name";
		$headers = 'From: '.$email;
		$email = "\n Email: $email";
		$phone = " \n Phone: $phone";
		$company = "\n Company: $company";
		$website = "\n Website: $website";
		$message = " \n Message: $message";
		


		$msg = "Inspiry $formName \n\n $name $email $phone $company $website $message";

		$to = $emailTo;
		$sub = $formName;
		if(mail($to, $sub, $msg, $headers)){
			return 200;
		}
		else { 
		return 400; 
		}
		}

	
?>