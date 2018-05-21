<?php
//PHP code to upload file to server directory
session_start();
date_default_timezone_set("America/New_York");
$currentTime = time();
if (!empty($_FILES))
{
	$email = $_SESSION['email'];
	$input = $_FILES['file']['tmp_name'];
	$temp = explode(".", $_FILES['file']['name']);
	$newFileName =  $email. '_' . $currentTime . '.' . end($temp);
	$targetFile =  "YOUR UPLOAD FOLDER". $newFileName;
	$_SESSION['file_path'] = $targetFile;
	if(!move_uploaded_file($input, $targetFile))
	{
		echo "Error occurred while uploading the file to server!";
	}
}
?>
