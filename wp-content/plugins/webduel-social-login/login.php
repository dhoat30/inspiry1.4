<?php
/**
 * Plugin Name: Webduel Social Login
 * Description: This plugin will add a Login with Google 
 * Plugin URI: https://webduel.co.nz
 * Author: Gurpreet Singh Dhoat
 * Version: 0.0.1
**/
//* Don't access this file directly
defined( 'ABSPATH' ) or die();


/**
 * Google App Configuration
 **/
// call sdk library
require_once 'google-api/vendor/autoload.php';

$gClient = new Google_Client();
$gClient->setClientId("207300494956-sh03jj7mc8i5no707hi13bejql50m25n.apps.googleusercontent.com");
$gClient->setClientSecret("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");
$gClient->setApplicationName("Inspiry Local and Live");
$gClient->setRedirectUri("https://inspiry.co.nz/wp-admin/admin-ajax.php?action=vm_login_google");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");


// login URL
$login_url = $gClient->createAuthUrl();

// google login 
// generate button shortcode
add_shortcode('google-login', 'vm_login_with_google');
function vm_login_with_google(){
    global $login_url;
    $btnContent = '
        <style>
            .googleBtn{
                display: block;
                margin: 0 auto;
                background: #4285F4;
                padding: 7px 0;
                border-radius: 3px;
                color: #fff;
                width: 100%; 
                text-align: center; 
                margin-top: 10px; 
            }
        </style>
    ';
    if(!is_user_logged_in()){
            // checking to see if the registration is opend
            if(!get_option('users_can_register')){
                return($btnContent . 'Registration is closed!');
            }else{
                return $btnContent . '<a class="googleBtn" href="'.$login_url.'">Login With Google</a>';
            }

    }else{
        $current_user = wp_get_current_user();
        return $btnContent . '<div class="googleBtn">Hi, ' . $current_user->first_name . '! - <a href="/wp-login.php?action=logout">Log Out</a></div>';
    }
	
}

// google login 
// add ajax action
 $redirectLink = "https://inspiry.co.nz/products"; 

add_action('wp_ajax_vm_login_google', 
		  function() use ($redirectLink){
			  vm_login_google($redirectLink); });

function vm_login_google($redirectLink){
	global $wp;
    // echo "fffff";
    global $gClient;
    // checking for google code
    if (isset($_GET['code'])) {
        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        var_dump($token);
    
        if(!isset($token["error"])){
            // get data from google
            $oAuth = new Google_Service_Oauth2($gClient);
            $userData = $oAuth->userinfo_v2_me->get();
        }

        // check if user email already registered
        if(!email_exists($userData['email'])){
            // generate password
            $bytes = openssl_random_pseudo_bytes(2);
            $password = md5(bin2hex($bytes));
            $user_login = $userData['id'];

            $new_user_id = wp_insert_user(array(
                'user_login'		=> $user_login,
                'user_pass'	 		=> $password,
                'user_email'		=> $userData['email'],
                'first_name'		=> $userData['givenName'],
                'last_name'			=> $userData['familyName'],
                'user_registered'	=> date('Y-m-d H:i:s'),
                'role'				=> 'customer'
                )
            );

            // get jwt token
            jwtToken($userData['email'], $password); 

            if($new_user_id) {
                // send an email to the admin
                wp_new_user_notification($new_user_id);
                
                // log the new user in
                do_action('wp_login', $user_login, $userData['email']);
                wp_set_current_user($new_user_id);
                wp_set_auth_cookie($new_user_id, true);
                
                // send the newly created user to the home page after login
                
                wp_redirect(home_url());
				exit;
            }
        }else{
            //if user already registered than we are just loggin in the user
            $user = get_user_by( 'email', $userData['email'] );

            // need it for jwt token 
            $bytes = openssl_random_pseudo_bytes(2);
            $password = md5(bin2hex($bytes));
            wp_set_password( $password, $user->ID);

            // get jwt token
            jwtToken($userData['email'], $password); 

            do_action('wp_login', $user->user_login, $user->user_email);
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true);
			
			  wp_redirect(home_url(  ));
			exit;
        }
        var_dump($userData);
    }else{
			          
         wp_redirect(home_url(  ));
        exit;
    }

}

// ALLOW LOGGED OUT users to access admin-ajax.php action
function add_google_ajax_actions(){
    add_action('wp_ajax_nopriv_vm_login_google', 'vm_login_google');
}
add_action('admin_init', 'add_google_ajax_actions');


// get jwt auth token 
function jwtToken($username, $password){
        // curl request for jwt token 
        $curl = curl_init();
        $postData = [ "username"=> $username, 
        "password"=> $password
                ];
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://inspiry.co.nz/wp-json/jwt-auth/v1/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $obj = json_decode($response);
            print_r($obj->token);
            // sett auth cookie 
            setcookie("inpiryAuthToken", $obj->token, time() + (86400 * 30), "/"); // 86400 = 1 day
}