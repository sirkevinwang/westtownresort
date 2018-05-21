<?php
	session_start();
	date_default_timezone_set("America/New_York");
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
	//
	if (!isset($_GET['code']))
	{
		header('Location: ' . filter_var("step1.php", FILTER_SANITIZE_URL));
	}
	else
	{
		$client->authenticate($_GET['code']);
		$access_token =  $client->getAccessToken();
		$refresh_token = $client->getRefreshToken();
		$_SESSION['access_token'] = $access_token;
		$_SESSION['refresh_token'] = $refresh_token;

		$service = new Google_Service_Oauth2($client);
		$user = $service->userinfo->get();
		$email =  $user->email;
    $_SESSION['email'] = $email;

		$name = $user->name;
		$now = date('Y-m-d G:i:s');
  	//connect to DB
    try
    {
      $db = new PDO ('mysql:host=YOUR SERVER ADDRESS;dbname=YOUR DB NAME','YOUR USER NAME','YOUR PASSWORD',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    }
    catch (PDOException $e)
    {
      echo 'Error connecting to DB!';
      exit;
    }

		if (isset($_SESSION['refresh_token'])) //First-time users -> save refresh token for background operations
		{
		//Check if user already exist
        $existCheckQuery = $db->prepare("SELECT refresh_token FROM users WHERE email = '$email'");
				$existCheckQuery->execute();
        $existRowsCount = $existCheckQuery->fetchColumn();
				echo "$existRowsCount";
				if ($existRowsCount > 0) //If the user revoked the refresh token and returned (ERR Handler)
				{
					$query = $db->prepare("UPDATE users
					SET access_token='$access_token', refresh_token='$refresh_token', username ='$name', token_init_timestamp = '$now'
				 	WHERE email = '$email'");
					$query->execute();
				}
				else //If the user is REALLY first-time
				{
					$query = $db->prepare("INSERT INTO users (access_token, refresh_token, token_init_timestamp, email, username)
				  VALUES ('$access_token', '$refresh_token', '$now', '$email', '$name')");
					$query->execute();
				}
		}
		else //Returned users -> save login record
		{
			$query1 = $db->prepare("INSERT INTO login_record (email) VALUES ('$email');");
			$query1->execute();
			$query2 = $db->prepare("UPDATE users SET access_token = '$access_token', token_init_timestamp = '$now' WHERE email = '$email'");
		  $query2->execute();
    }
		header('Location: ' . filter_var("step2.php", FILTER_SANITIZE_URL));
  }
?>
