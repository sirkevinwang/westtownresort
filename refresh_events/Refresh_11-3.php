<?php
error_reporting(E_ERROR);
session_start();
date_default_timezone_set("America/New_York");
require_once __DIR__.'/vendor/autoload.php';
$client_secret = 'uQe3JMN7wLt1MA_mJimEjoPr';
$client_id = '532734132886-vl05f2vrn4onvq2l1gojv8b9k49g1g3s.apps.googleusercontent.com';

try{
  $db = new PDO ('mysql:host=localhost;dbname=resort','root','WesttownGlobalServices',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}
catch (PDOException $e) {
  echo 'Error connecting to SQL Server!';
  exit;
}

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->addScope("https://www.googleapis.com/auth/calendar");
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
$client->setAccessType("offline");
$calendarId = 'primary';

$get_data = $db -> prepare("SELECT * FROM `users`");
$get_data -> execute();
$row = [];
while($get_info = $get_data -> fetch(PDO::FETCH_ASSOC))
{
  $row[] = $get_info;
}

foreach ($row as $key => $data)
{
  $token = $data['refresh_token'];
  $name = $data['username'];
  $client->refreshToken($token);
  $calendarService = new Google_Service_Calendar($client);
  $event = new Google_Service_Calendar_Event(array(
              'summary' => '"Audrie & Daisy" & Debriefing',
              'location' => "Day - Science Lecture Hall
B2/G2/BH - BCR
B3/G3/GH - GCR",
              'start' => array(
                'dateTime' => "2016-11-03T10:50:00",
                'timeZone' => 'America/New_York',
                ),
              'end' => array(
                'dateTime' => "2016-11-03T13:05:00",
                'timeZone' => 'America/New_York',
                ),
              'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                  array('method' => 'popup', 'minutes' => 10)
                  ),),));
$calendarService->events->insert($calendarId, $event);
print("$name OK");
print("\r\n");
}
?>
