<?php
error_reporting(E_ERROR);
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

$get_data = $db -> prepare("SELECT * FROM `users` WHERE success='YES'");
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
  print($name);
  $client->refreshToken($token);
  $calendarService = new Google_Service_Calendar($client);
  $optionalParams = array('timeMin' => '2017-01-04T07:00:00-04:00',
  'timeMax' => '2017-01-04T09:14:00-04:00');
  $events = $calendarService->events->listEvents('primary');

while(true)
{
  $pageToken = $events->getNextPageToken();
  if ($pageToken)
  {
    $optParams = array('pageToken' => $pageToken);
    $events = $calendarService->events->listEvents('primary', $optionalParams);
    if (isset($events))
    {
      foreach ($events as $k => $event)
      {
        $summary = $event["summary"];
        print($summary);
        if ($summary == "Late Start ")
        {
          $event->setSummary('Special Assembly');
          $event->setLocation('Theater');
          $calendarService->events->update('primary', $event->getId(), $event);
          print("$name OK");
          break;
        }else
        {
          break;
        }
      }
      break;
    }
    break;
  }
  break;
 }
}
?>
