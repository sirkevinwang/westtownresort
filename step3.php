<?php
date_default_timezone_set("America/New_York");
session_start();
$_SESSION["freePeriod"] = "FALSE";
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
  <link rel="icon" type="image/ico" href="libs/images/favicon.ico">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Westtown Resort</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.css" integrity="sha256-MAnh/C29ofvqOpLJcehY/VV0oEoJ3zyQxO6Q1yzicbM=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css" integrity="sha256-0Z6mOrdLEtgqvj7tidYQnCYWG3G2GAIpatAWKhDx+VM=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/css/animsition.min.css" integrity="sha256-FAIOZJGGkyuIp/gVrVL/k52z4rpCKMrRlYMdGCWstUo=" crossorigin="anonymous" />
  <link rel="stylesheet" href="libs/css/indicator.css">
  <link rel="stylesheet" href="libs/css/step3.css">


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
        <h2>Step 3<br>Upload your schedule</h2>
      </div>
      <div class="container">
        <input type="checkbox" id="freePeriod"> Show free periods as "free"<br>
       <form action="upload.php" class="dropzone decoration"
       id="my-awesome-dropzone"></form>
     </div>
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <!-- Include all compiled plugins (below), or include individual files as needed -->
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.js" integrity="sha256-t9aPQUaXIi/wLsLq3WqIIakTuBHJMc+ZTnmAjeBauhw=" crossorigin="anonymous"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js" integrity="sha256-vnXjg9TpLhXuqU0OcVO7x+DpR/H1pCeVLLSeQ/I/SUs=" crossorigin="anonymous"></script>
     <script>

     </script>
     <script>
      Dropzone.options.myAwesomeDropzone =
      {
        dictDefaultMessage: "Drag and drop the file you just saved here.",
        maxFiles: 1,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFilesize: 0.1,
        acceptedFiles: ".html, .htm",

        removedfile: function(file) {
          var fileRef;
          return (fileRef = file.previewElement) != null ?
          fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },

        success: function(file) {
          swal({
            title: "Success!",
            text: "We've received your schedule. <br> You may close this page or wait until <br> we redirect you once we are finished. <br> This will take up to 1 minute. <br>",
            type: "success",
            showConfirmButton: false
          }),
          setTimeout(function() {
            window.location.href = "finish.php";
          }, 2000);

        },
        error: function(file) {
          swal(
            'Error!',
            'You can only upload HTML files',
            'error'
            );
        }

      };

      $('#freePeriod').change(function() {
        if($(this).is(":checked")) {
          $.get( "check.php", function() {
        });
    }
    else {
      $.get( "uncheck.php", function() {
    });
    }
});
    </script>
  </body>
  </html>
