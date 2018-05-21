<?php
session_start();
if (isset($_SESSION['access_token']))
{
  session_destroy();
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
  <link rel="stylesheet" href="libs/css/thanks.css">
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
        <h2>Thank You<br>You are all set!</h2>
      </div>
      <p>Your schedule is now available on Google Calendar. <br>You can now set up your schedule on all of your devices.</p>
      <a href="https://calendar.google.com"><button class="btn btn-google">
        <img src="libs/images/google_sign_in_btn.svg" class="sign-in-btn">Google Calendar</button>
      </a>
    </div>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/js/animsition.min.js" integrity="sha256-8y2mv4ETTGZLMlggdrgmCzthTVCNXGUdCQe1gd8qkyM=" crossorigin="anonymous"></script>
      <script src="libs/js/transition.js"></script>
    </body>
    </html>
