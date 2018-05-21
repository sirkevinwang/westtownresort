<?php
error_reporting(E_ERROR);
session_start();
date_default_timezone_set("America/New_York");
if(isset($_SESSION['access_token']))
{
  if(isset($_SESSION['file_path']))
  {
    $token = $_SESSION['access_token'];
    $path = $_SESSION['file_path'];
    require_once __DIR__.'/vendor/autoload.php';
    $client_secret = 'YOUR CLIENT SECRET';
    $client_id = 'YOUR CLIENT ID';

    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->addScope("https://www.googleapis.com/auth/calendar");
    $client->addScope("https://www.googleapis.com/auth/userinfo.email");
    $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
    $client->setAccessType("offline");
    $client->setUseBatch(true);
    $client->setAccessToken($token);
    $calendarId = 'primary';

    $calendarService = new Google_Service_Calendar($client);
    $file = file_get_contents($path);
    $quarter = "";
    $semester = "";
    $faculty = false;

    if(strpos($file, 'Faculty Preferences') !== false)
      {$faculty = true;}

    $DOM = new DOMDocument();
    $DOM->loadHTML($file);
    $optionTags = $DOM->getElementsByTagName('option');
    for ($i = 0; $i < $optionTags->length; $i++ )
    {
      if ($optionTags->item($i)->hasAttribute('selected')
        && $optionTags->item($i)->getAttribute('selected') === "selected")
      {
        $quarter = $optionTags->item($i)->nodeValue;
      }
    }
    $quarter = substr($quarter, -1);
    switch ($quarter)
    {
      case '1': $semester = "s1_rotation";
      break;
      case '2': $semester = "s1_rotation";
      break;
      case '3': $semester = "s2_rotation";
      break;
      case '4': $semester = "s2_rotation";
      break;
    }

    if ($faculty !== true)
    {
      $tmp_dom = new DOMDocument();
      foreach ($DOM->getElementsByTagName('table') as $tag)
      {
        if ($tag->getAttribute('class') === 'studentTable')
        {
          foreach($tag->getElementsByTagName('td') as $node)
          {
            $tmp_dom->appendChild($tmp_dom->importNode($node,true));
          }
        }
      }
      $Actual.=trim($tmp_dom->saveHTML());
      $toBeReplaced = array(' class="scheduleDataCellEven" colspan="1"', ' class="scheduleDataCellOdd" colspan="1"', '<td>&nbsp;</td>');
      $returned = str_replace($toBeReplaced, "", $Actual);
      $domNG = new DOMDocument;
      $domNG->loadHTML($returned);
      foreach($domNG->getElementsByTagName('td') as $node)
      {
        $Array[] = $domNG->saveHTML($node);
      }

      $nameArray = array();
      $locationArray = array();
      $startArray = array();
      $endArray = array();

      foreach($Array as $value)
      {
        $td = array('<td>', '</td>');
        $noTd = str_replace($td, '', $value);

            if(strpos($noTd, 'amp;') !== false) //exception --> e.g. E&M
            {$noTd = str_replace('amp;', '', $noTd);}

            if(strpos($noTd, '<hr>'))
            {
              $noTd = strstr($noTd, '<hr>');
              $noTd = str_replace('<hr>', '', $noTd);
            }

            $numberOfBreaks = substr_count($noTd, '<br>');
            $explodeArray = explode('<br>', $noTd);
            $pushName = "";
            $pushLocation = "";
            $pushStartTime = "";
            $pushEndTime = "";

            if ($numberOfBreaks == 2) //Normal Classes
            {
              $pushName = $explodeArray[0];
              $pushLocation = $explodeArray[1];
              $rawTime = explode('-', $explodeArray[2]);
            }
            elseif ($numberOfBreaks == 1) //3 Special
            {
              if ((preg_match('/\pL.*\pN|\pN.*\pL/s', $explodeArray[0]))) //INDEPENDENT Research
              {
                $pushName = $explodeArray[0];
                $pushLocation = "";
                $rawTime = explode('-', $explodeArray[1]);
              }
              elseif (preg_match('/[a-zA-Z]+./', $explodeArray[0]))
              {
                $pushName = $explodeArray[0];
                $rawTime = explode('-', $explodeArray[1]);
              }
              elseif (preg_match('/\\d/', $explodeArray[0]))
              {
                if ($_SESSION["freePeriod"] == "TRUE")
                {
                  if ($explodeArray[0] == "11 ")
                  {
                    $rawTime = "";
                  }
                  else
                  {
                  $pushName = "Free";
                  $pushLocation = "";
                  $rawTime = explode('-', $explodeArray[1]);
                  }
                }
                else
                {
                  $rawTime = "";
                }
              }
            }

            if (!empty($rawTime))
            {
              if (strpos($rawTime[1], 'PM'))
              {
                $amBool = strpos($rawTime[0], 'AM');
                $pmBool = strpos($rawTime[0], 'PM');
                if (($amBool == false) && $pmBool == false)
                {
                  $pushStartTime = date("H:i:s", strtotime($rawTime[0] . 'PM'));
                }
                else
                {
                  $pushStartTime = date("H:i:s", strtotime($rawTime[0]));
                }
              }
              else
              {
                $pushStartTime = date("H:i:s", strtotime($rawTime[0] . 'AM'));
              }
              $pushEndTime = date("H:i:s", strtotime($rawTime[1]));
            }

            if ($numberOfBreaks !== 0)
            {
              array_push($nameArray, $pushName);
              array_push($locationArray, $pushLocation);
              array_push($startArray, $pushStartTime);
              array_push($endArray, $pushEndTime);
            }
        }
      }
      else
      {
          $tmp_dom = new DOMDocument();
          foreach ($DOM->getElementsByTagName('table') as $tag)
          {
            if ($tag->getAttribute('class') === 'dataTable')
            {
              foreach($tag->getElementsByTagName('td') as $node)
              {
                $tmp_dom->appendChild($tmp_dom->importNode($node,true));
              }
            }
          }

          $Actual.=trim($tmp_dom->saveHTML());
          $toBeReplaced = array(' class="cellAlignCenter" colspan="1"><span class="dataHeaderBorderless textBold"', ' class="scheduleDataCellOdd dataColumnNoWrap cellAlignCenter" colspan="1"', ' class="scheduleDataCellEven dataColumnNoWrap cellAlignCenter" colspan="1"','<td class="scheduleDataCellEven dataColumnNoWrap cellAlignCenter" colspan="1"></td>', '<td class="scheduleDataCellOdd dataColumnNoWrap cellAlignCenter" colspan="1"></td>', '<td></td>');
          $returned = str_replace($toBeReplaced, "", $Actual);
          $returned = str_replace('Late Start', 'Faculty Meeting', $returned);
          $domNG = new DOMDocument;
          $domNG->loadHTML($returned);
          foreach($domNG->getElementsByTagName('td') as $node)
          {
            $array[] = $domNG->saveHTML($node);
          }

          $nameArray = array();
          $locationArray = array();
          $startArray = array();
          $endArray = array();

          foreach($array as $value)
          {
            $pushName = "";
            $pushLocation = "";
            $pushStartTime = "";
            $pushEndTime = "";
            $td = array('<td>', '</td>');
            $noTd = str_replace($td, '', $value);
            if(strpos($noTd, '<hr>'))
            {
              $noTd = strstr($noTd, '<hr>');
              $noTd = str_replace('<hr>', '', $noTd);
            }
            if(strpos($noTd, 'amp;'))
            {$noTd = str_replace('amp;', '', $noTd);}

            if(strpos($noTd, '<br>'))
            {
              $explodeArray = explode('<br>', $noTd);
              array_pop($explodeArray);
              if (!is_numeric($explodeArray[0]))
              {
                $pushName = $explodeArray[0];
                $rawTime = explode(' - ', $explodeArray[2]);
                $raw1 = $rawTime[0];
                $raw2 = $rawTime[1];
                $raw1Int = (int)str_replace(':', '', $raw1);
            if (substr("$raw1", 0, 2) == "11") //Type I: AM->PM
            {
              $pushStartTime = date("H:i:s", strtotime($rawTime[0] . 'AM'));
              $pushEndTime = date("H:i:s", strtotime($rawTime[1] . 'PM'));
            }
            elseif (substr("$raw1", 0, 2) == "12")
            {
              $pushStartTime = date("H:i:s", strtotime($rawTime[0] . 'PM'));
              $pushEndTime = date("H:i:s", strtotime($rawTime[1] . 'PM'));
            }
            elseif ($raw1Int <= 700)
            {
              $pushStartTime = date("H:i:s", strtotime($rawTime[0] . 'PM'));
              $pushEndTime = date("H:i:s", strtotime($rawTime[1] . 'PM'));
            }
            else
            {
              $pushStartTime = date("H:i:s", strtotime($rawTime[0] . 'AM'));
              $pushEndTime = date("H:i:s", strtotime($rawTime[1] . 'AM'));
            }
          }
          $pushLocation = $explodeArray[1];
          array_push($nameArray, $pushName);
          array_push($locationArray, $pushLocation);
          array_push($startArray, $pushStartTime);
          array_push($endArray, $pushEndTime);
        }
    }
  }

  //Clear Sport slot to "Co-Curricular"
  for ($in = 110; $in <= 119; $in++)
  {
    $currentValue = $nameArray[$in];
    if (!empty($currentValue))
    {
      $nameArray[$in]  = "Co-Curricular";
    }
  }
    //DB connector
    try{
      $db = new PDO ('mysql:host=YOUR SERVER ADDRESS;dbname=YOUR DB NAME','YOUR USER NAME','YOUR PASSWORD',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    }
    catch (PDOException $e) {
      echo 'Error connecting to SQL Server!';
      exit;
    }

    $get_data = $db -> prepare("SELECT * FROM `$semester`");
    $get_data -> execute();
    $row = [];
    while($get_info = $get_data -> fetch(PDO::FETCH_ASSOC))
    {
      $row[] = $get_info;
    }

    $batch = new Google_Http_Batch($client);
    $batchCount = 0;
    foreach ($row as $key => $data)
    {
          $dayOfWeek = date("N", strtotime($data['date']));      //date -> day of week INT
          $dayOfWeek = $dayOfWeek - 1;       //Convert into index of first row without known AB week
          if($data['type'] == 'A')
          {
            $i = $dayOfWeek;
            $max = $i + 120; //max is always 120 elements away
            while($i <= $max)
            {
              $n = $nameArray[$i];
              if (!empty($n))
              {
                $l = $locationArray[$i];
                $s = $data['date'] . "T" . $startArray[$i];
                $e = $data['date'] . "T" . $endArray[$i];
                //Create event
              if ($n == "Free")
              {
                $event = new Google_Service_Calendar_Event(array(
                  'summary' => "$n",
                  'location' => "$l",
                  'start' => array(
                    'dateTime' => "$s",
                    'timeZone' => 'America/New_York',
                    ),
                  'end' => array(
                    'dateTime' => "$e",
                    'timeZone' => 'America/New_York',
                    ),
                  'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                      array('method' => 'popup', 'minutes' => 5)
                      )
                    ),
                    'transparency' => "transparent"
                  ));
                $req = $calendarService->events->insert($calendarId, $event);
              }
              else {
                $event = new Google_Service_Calendar_Event(array(
                  'summary' => "$n",
                  'location' => "$l",
                  'start' => array(
                    'dateTime' => "$s",
                    'timeZone' => 'America/New_York',
                    ),
                  'end' => array(
                    'dateTime' => "$e",
                    'timeZone' => 'America/New_York',
                    ),
                  'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                      array('method' => 'popup', 'minutes' => 5)
                      ),),));
                $req = $calendarService->events->insert($calendarId, $event);
              }
                if ($batchCount < 50)
                {
                  $batch->add($req);
                  $batchCount += 1;
                }elseif ($batchCount == 50)
                {
                  $batchResult = $batch->execute();
                  $batch = new Google_Http_Batch($client);
                  $batchCount = 0;
                  $batch->add($req);
                  $batchCount += 1;
                }
              }
              $i+=10;
            }
          }
          elseif($data['type'] == 'B') //add 5 to i to get the index in first row
          {
            $i = $dayOfWeek + 5;
            $max = $i + 120; //max is always 120 elements away
            while($i <= $max)
            {
              $n = $nameArray[$i];
              if(!empty($n))
              {
                $l = $locationArray[$i];
                $s = $data['date'] . "T" . $startArray[$i];
                $e = $data['date'] . "T" . $endArray[$i];
                  //Create event
                $event = new Google_Service_Calendar_Event(array(
                  'summary' => "$n",
                  'location' => "$l",
                  'start' => array(
                    'dateTime' => "$s",
                    'timeZone' => 'America/New_York',
                    ),
                  'end' => array(
                    'dateTime' => "$e",
                    'timeZone' => 'America/New_York',
                    ),
                  'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                      array('method' => 'popup', 'minutes' => 5)
                      ),),));
                $req = $calendarService->events->insert($calendarId, $event);
                if ($batchCount < 50)
                {
                  $batch->add($req);
                  $batchCount += 1;
                }elseif ($batchCount == 50)
                {
                  $batchResult = $batch->execute();
                  $batch = new Google_Http_Batch($client);
                  $batchCount = 0;
                  $batch->add($req);
                  $batchCount += 1;
                }
              }
              $i += 10;
            }
          }
        }
        $batchResult = $batch->execute();
        $email = $_SESSION['email'];
        $confirmQuery = $db->prepare("UPDATE users SET success='YES'WHERE email='$email';");
  			$confirmQuery->execute();
        header('Location: ' . filter_var("thanks.php", FILTER_SANITIZE_URL));
  }
}
?>
