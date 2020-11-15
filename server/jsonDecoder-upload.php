<?php

//TO DO stmt1 και τα υπολοιπα εκτος απο το stmt0 να κανουν close
//upload the correct file
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
set_time_limit (0);
ini_set('memory_limit', '-1');

//Εδω αυτη η συνάρτηση μετράει την απόσταση ενός σημείο με βάση κάποιο άλλο σημείο για να δεί αν ανήκει σε ένα συγκεκριμένο radius
//Στην συγκεκριμένη περίπτωση αν είναι σε απόσταση 10km απο το κέντροπ της πάτρας.
function getDistanceBetweenPointsNew($latitude_center, $longitude_center, $latitude_point, $longitude_point, $unit = 'Km') {
    $theta = $longitude_center - $longitude_point;
    $distance = sin(deg2rad($latitude_center)) * sin(deg2rad($latitude_point)) + cos(deg2rad($latitude_center)) * cos(deg2rad($latitude_point)) * cos(deg2rad($theta));

    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;

    switch($unit) { //Μεταροπη Mph σε Km
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344;
    }
    return (round($distance,7)); //Στρογγυλοποίηση σε 7 δεκαδικα ψηφ'ια
}



//ΑΝ ΠΑΤΗΘΕΙ ΤΟ ΤΕΛΙΚΟ ΚΟΥΜΠΙ για upload
if (isset($_POST['final_confirmation']))
{
  $date_time = date ('Y-m', time());
  

    $resource = opendir(__DIR__.'/../server/uploads'); //Έλεγχος directory
    while(($files = readdir($resource)) !== false) { //Αν δεν είναι άδειο το directory  διαβασε τα αρχεία
        if ($files != '.' && $files != '..') { 
        
            // Check connection με ΒΔ
            $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;


        $data = file_get_contents('http://localhost/test/server/uploads/'.$files);
        $rows = json_decode($data, true);

        $sql_map_data = "INSERT INTO map_data (userID, dataID, uploadDate, fileName) VALUES (?, ?, ?, ?)";
        $stmt0 = $dbconnect->prepare($sql_map_data);
        date_default_timezone_set('Europe/Athens');//Μετατροπη στο κατάλληλο timezone για το log του server
        $json_upload_date = date ('Y-m-d H:i:s', time());
        $filename=$_POST['json_file_name'];
        echo $filename;
        $zero_int = 0;
            $stmt0->bind_param('siss', $_SESSION['userID'], $zero_int, $json_upload_date, $filename);
            if($stmt0->execute())
            {
              //echo "Successful map_data upload";
              //print_r($rows);
              $stmt0->close();
      
              if (is_array($rows) || is_object($rows)) { // Αν είναι array ή object συνέχισε για parsing.
                foreach ($rows['locations'] as $row) { //This one right here loops all the locations in the json that the user uploaded.
                  $sql1 = "INSERT INTO locations (userID, dataID, locationID, timestampMs, latitude, longitude, velocity, accuracy, heading, altitude, verticalAccuracy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                  //$stmt1 = mysqli_stmt_init($connection);
                  $stmt1 = $dbconnect->prepare($sql1);
                  if (!$stmt1) { //This one right here will check if the sql statement above working properly.
                    echo "Connection failed1!";
                    exit();

                  }
                  else {
                    
                    $thisTimestampMs_l = date('Y-m-d H:i:s', $row['timestampMs'] / 1000); //Μετατροπή σε datetime αντί timestampMs
                    $thisLatitude = $row['latitudeE7'] / pow(10, 7);
                    $thislongitude = $row['longitudeE7'] / pow(10, 7);

                    if (getDistanceBetweenPointsNew(38.230462, 21.753150, $thisLatitude, $thislongitude) < 10.0) { //Κόψιμο αποστάσεων που δεν ανήκουν στο radius που θεμε.
                      $stmt1->bind_param("siisddiiiii", $_SESSION['userID'],$zero_int , $zero_int, $thisTimestampMs_l, $thisLatitude, $thislongitude, $row['velocity'], $row['accuracy'], $row['heading'], $row['altitude'], $row['verticalAccuracy']);
                      $stmt1->execute();

                      if (isset($row['activity']) && (is_array($row['activity']) || is_object($row['activity']))) { // Αν είναι array ή objectσυνέχισε για parsing.
                        foreach ($row['activity'] as $ro) { //Αρχικά activity πίνακας activity στην ΒΔ
                          $sql2 = "INSERT INTO activity(userID, dataID, locationID, activityID, timestampMs) VALUES (?, ?, ?, ?, ?)";
                          $stmt2 = $dbconnect->prepare($sql2);
                          if (!$stmt2) { //Αν ολα καλα με mysql server και querries συνέχισε και εκτέλεσε το
                            echo "Connection failed2!";
                            exit();
                          }
                          else {
                            $thisTimestampMs_a = date('Y-m-d H:i:s', $ro['timestampMs'] / 1000); //Μετατροπή σε datetime αντί timestampMs
                            $stmt2->bind_param("siiis", $_SESSION['userID'], $zero_int, $zero_int, $zero_int, $thisTimestampMs_a);
                            $stmt2->execute();

                            if (is_array($ro['activity']) || is_object($ro['activity'])) { // Αν είναι array ή object συνέχισε για parsing.
                              foreach ($ro['activity'] as $r) { //Εμφωλευμένα activities δλδ sub_activities πίνακας sub_activity
                                $sql3 = "INSERT INTO sub_activity(userID, dataID, locationID, activityID, sub_activityID, activityType, confidence, timestampMs) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt3 = $dbconnect->prepare($sql3);
                                if (!$stmt3) { //Αν ολα καλα με mysql server και querries συνέχισε και εκτέλεσε το
                                  echo "Connection failed!3";
                                  exit();
                                }
                                else {
                                  $stmt3->bind_param("siiiisis", $_SESSION['userID'], $zero_int, $zero_int, $zero_int, $zero_int, $r['type'], $r['confidence'], $thisTimestampMs_a);
                                  $stmt3->execute();
                                } //else closes.
                              } //foreach closes.
                            } //if closes.
                          } //else closes.
                        } //foreach closes.
                      } //if closes.
                    } //functions if closes.
                  } //else closes.
                } //foreach closes.
              } //if closes.
            //$stmt0->close();//kleisimo query
            }//if closes initialinsertion on map_data
            else
            {
              $notification2 = "Error insertion into database";
              echo $notification2;
            }
            
        unlink(__DIR__.'/../server/uploads/'.$files); //Διαγραφή αρχείου από τον server που μολίς εδωσε δεδομένα στην ΒΔ για να μην πιάνει τσάμπα χώρο
      } //if closes.
    } //while closes.
    //$stmt1->close();
    //$stmt2->close();
    //$stmt3->close();
    require(__DIR__.'/../user/left_window_info.php');//ΑΝΑΝΕΩΣΗ ΔΕΔΟΜΕΝΩΝ ΜΕ ΒΑΣΗ ΤΟ ΝΕΟ UPLOAD
    //header("location: http://localhost/test/user/upload.php");


  }
  
  //header("Location: ../index.php"); //This one right here takes you back to the main page.


?>
