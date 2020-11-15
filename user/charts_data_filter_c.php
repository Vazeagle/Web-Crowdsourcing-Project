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


//get data from database querries
$current_userID = $_SESSION['userID'];
$dayArray = array();
$percentageArray = array();
$bothArray = array();

for ($i=0; $i < 7; $i++) {
    $sql_1 = "SELECT * FROM sub_activity WHERE userID = '$current_userID'"; // This one right here selects everything from activity_details table. I want only the count but I will retrieve it with mysqli_num_rows() function.
    $sql_3 = "SELECT timestampMs FROM sub_activity WHERE WEEKDAY(timestampMs) = $i AND userID = '$current_userID'";

    $stmt = mysqli_stmt_init($dbconnect);
    if (!mysqli_stmt_prepare($stmt, $sql_1) || !mysqli_stmt_prepare($stmt, $sql_3)) { //This one right here will check if the sql statement above working properly.
        echo "Connection failed!";
        exit();
    }
    else{
        $result_1 = mysqli_query($dbconnect, $sql_1);
        $resultCheck_1 = mysqli_num_rows($result_1);
        $result_3 = mysqli_query($dbconnect, $sql_3);
        $resultCheck_3 = mysqli_num_rows($result_1);

        while($resultCheck_3 = mysqli_fetch_array($result_3)){
        $timestamp_a = $resultCheck_3["timestampMs"];
        $dayNumber = date("d", strtotime($timestamp_a));
        $dayLetter = date("D", strtotime($timestamp_a));
        if(!in_array($dayLetter, $dayArray, true)){
            $sql_2 = "SELECT * FROM sub_activity WHERE WEEKDAY(timestampMs) = $i AND userID = '$current_userID'"; // This one right here selects everything from activity_details table. I want only the count but I will retrieve it with mysqli_num_rows() function.
            $result_2 = mysqli_query($dbconnect, $sql_2); // This one right here stores the query into a variable.
            $resultCheck_2 = mysqli_num_rows($result_2); // This one right here stores the mysqli_num_rows() into a variable.
            array_push($dayArray, $dayLetter); // This one right here pushes to the array the type of the activity
            array_push($percentageArray, ($resultCheck_2 / $resultCheck_1) * 100); // This one right here pushes to the array the activity_percentage of the activity.
        }
        }
    }
    }
// echo array_sum($percentageArray);
$bothArray['dayArray'] = $dayArray;
$bothArray['percentageArray'] = $percentageArray;
echo json_encode($bothArray); // This one right here encodes both array to a JSON.



?>