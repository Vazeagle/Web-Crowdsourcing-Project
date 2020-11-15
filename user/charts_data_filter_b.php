<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }




$myFile = "empty.txt";
$lines = file($myFile); //file in to an array
$starting_year = $lines[0];
$starting_year = str_replace("\n", "", $starting_year);
$ending_year = $lines[1];
$ending_year = str_replace("\n", "", $ending_year);
$starting_month = $lines[2];
$starting_month = date('m', strtotime($starting_month));
$ending_month = $lines[3];
$ending_month = date('m', strtotime($ending_month));
$starting_date = $starting_year . "-" . $starting_month . "-00";
$ending_date = $ending_year . "-" . $ending_month . "-00";

$dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project");

$hourArray = array();
$percentageArray = array();
$bothArray = array();

//get data from database querries
$sql_1 = "SELECT * FROM sub_activity";
$sql_3 = "SELECT timestampMs FROM sub_activity";

$stmt = mysqli_stmt_init($dbconnect);
if (!mysqli_stmt_prepare($stmt, $sql_1) || !mysqli_stmt_prepare($stmt, $sql_3)) { //This one right here will check if the sql statement above working properly.
  echo "Connection failed!";
  exit();
}
else{
  $result_1 = mysqli_query($dbconnect, $sql_1); // This one right here stores the query into a variable.
  $resultCheck_1 = mysqli_num_rows($result_1); // This one right here stores the mysqli_num_rows() into a variable.
  $result_3 = mysqli_query($dbconnect, $sql_3); // This one right here stores the query into a variable.
  while($resultCheck_3 = mysqli_fetch_array($result_3)){
    $timestamp_a = $resultCheck_3["timestampMs"];
    $hourNumber = date("H", strtotime($timestamp_a));
    $hourLetter = date("H", strtotime($timestamp_a));
    if(!in_array($hourLetter, $hourArray, true)){
        $sql_2 = "SELECT * FROM sub_activity WHERE timestampMs LIKE '____-__-__ $hourNumber:__:__'"; // This one right here selects everything from activity_details table where type is something that the admin choose in frontend. I want only the count but I will retrieve it with mysqli_num_rows() function.

        $result_2 = mysqli_query($dbconnect, $sql_2); // This one right here stores the query into a variable.
        $resultCheck_2 = mysqli_num_rows($result_2); // This one right here stores the mysqli_num_rows() into a variable.
        array_push($hourArray, $hourLetter); // This one right here pushes to the array the type of the activity
        array_push($percentageArray, ($resultCheck_2 / $resultCheck_1) * 100); // This one right here pushes to the array the activity_percentage of the activity.
    }
  }
  // echo array_sum($percentageArray);
  $bothArray['hourArray'] = $hourArray;
  $bothArray['percentageArray'] = $percentageArray;
  echo json_encode($bothArray); // This one right here encodes both array to a JSON.
}
// $stmt_c2 = $dbconnect->prepare($user_hour_day_act_query);
// $stmt_c2->bind_param('sss', $_SESSION['userID'], $starting_date, $ending_date);
// if($stmt_c2->execute())//Αν εκτελεστει και ολα οκ προχωρα
// {
//     $result_c2 = $stmt_c2->get_result();
//     $rows_returned_b = $result_c2->num_rows;
//     $activity_type2 = array();
//     $activity_hour = array();
//     //store data to arrays
//     while($row_data_c2=$result_c2->fetch_assoc())
//     {
//         array_push($activity_type2, $row_data_c2["activity"]);
//         array_push($activity_hour, $row_data_c2["hour"]);
//     }
//     $result_c2->free_result();
//     $stmt_c2->close();
//     //get data to final array
//     for ($rep = 0; $rep <$rows_returned_b ; $rep++)
//     {
//         array_push($activity_type2, $activity_hour[$rep]);
//     }
//     $_SESSION['hour_of_day_activity_chart']=$activity_type2;

// }
// else
// {
//     $notification = "Error getting user charts info!";
//     $stmt_c2->close();
// }

// echo json_encode($_SESSION['hour_of_day_activity_chart']);

?>