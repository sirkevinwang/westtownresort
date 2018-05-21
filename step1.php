<?php

date_default_timezone_set("America/New_York");
session_start();
require_once __DIR__.'/vendor/autoload.php';
$client_secret = 'YOUR CLIENT SECRET';
$client_id = 'YOUR CLIENT ID';
$redirect_uri = 'YOUR REDIRECT URI';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/calendar");
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
$client->setAccessType("offline");
$service = new Google_Service_Oauth2($client);

if (isset($_SESSION['access_token']))
{
  session_destroy();
}
else
{
  $authUrl = $client->createAuthUrl();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <link rel="icon" type="image/ico" href="libs/images/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Westtown Resort</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/css/animsition.min.css" integrity="sha256-FAIOZJGGkyuIp/gVrVL/k52z4rpCKMrRlYMdGCWstUo=" crossorigin="anonymous" />
  <link rel="stylesheet" href="libs/css/indicator.css">
  <link rel="stylesheet" href="libs/css/step1.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>
    <nav class="navbar navbar-resort navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <img class="navbar-brand" id="logo" src="libs/images/logo.png">
        </div>
      </div>
    </nav>
    <div class="container content">
      <div class="header">
        <h2>Step 1<br>Sign-in with Westtown Account</h2>
      </div>
      <p>Signing in will grant us access to your Google Calendar<br>Resort needs your permission to add your events to your calendar.</p>
       <a href="<?php if (isset($authUrl)){echo $authUrl;}?>">
         <button class="btn btn-google"><img src="libs/images/google_sign_in_btn.svg" class="sign-in-btn">Sign in with Google</button>
       </a>
      </div>
    </div>


      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/js/animsition.min.js" integrity="sha256-8y2mv4ETTGZLMlggdrgmCzthTVCNXGUdCQe1gd8qkyM=" crossorigin="anonymous"></script>
      <script src="libs/js/transition.js"></script>
    </body>
    </html>
