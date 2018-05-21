<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set("America/New_York");

$user_agent = getenv("HTTP_USER_AGENT");
if(strpos($user_agent, "Win") !== FALSE)
{$os = "Windows";}
elseif(strpos($user_agent, "Mac") !== FALSE)
{$os = "Mac";}
session_start();
if (!isset($_SESSION['access_token']))
{
  header('Location: ' . filter_var("step1.php", FILTER_SANITIZE_URL));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Westtown Resort</title>
  <link rel="icon" type="image/ico" href="libs/images/favicon.ico">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="libs/css/indicator.css">
  <link rel="stylesheet" href="libs/css/step2.css">

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
            <img class="navbar-brand" src="libs/images/logo.png">
          </div>
        </div>
      </nav>
      <div class="container-fluid content text-center">
        <div class="header">
          <h2>Step 2<br>Save your schedule</h2>
        </div>
        <div class="container block-center">
          <div>
            <?php
            if($os == "Mac")
            {
              if(stripos($user_agent, 'Chrome') == FALSE)
              {
                echo "<video autoplay loop type='video/mp4' src='libs/video/html_safari.mp4' class='mediaObject-element' style='width: 548px; height: 308px; visibility: visible;'>";
              }
              else
              {
              echo "<video autoplay loop type='video/mp4' src='libs/video/html_mac.mp4' class='mediaObject-element' style='width: 548px; height: 308px; visibility: visible;'>";
              }
            }
            else
            {
              echo "<video autoplay loop type='video/mp4' src='libs/video/html_pc.mp4' class='mediaObject-element' style='width: 548px; height: 308px; visibility: visible;'>";
            }
            ?>
          </video>
          </div>
          <a href="https://mbp.westtown.edu/SeniorApps/studentParent/schedule.faces?selectedMenuId=true" target="_blank"><button class="btn btn-google">MyBackpack</button></a>
          <a href="step3.php"><button class="btn btn-google">Next</button></a>
          <br>
          <a href="https://mbp.westtown.edu/SeniorApps/faculty/mySchedule/mySchedule.faces?selectedMenuId=true" target="_blank" id="faculty_redirect">Faculty? Click me to go to MyBackpack</a>
        </div>
      </div>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
    </html>
