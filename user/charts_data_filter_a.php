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
$user_act_data_query= "SELECT activityType, COUNT(*) AS counter FROM sub_activity WHERE userID = ? AND timestampMs >= ?  AND timestampMs<= ? GROUP BY activityType";
$userID = $_SESSION['userID'];
$stmt_c1 = $dbconnect->prepare($user_act_data_query);
$stmt_c1->bind_param('sss', $userID, $starting_date, $ending_date);
if($stmt_c1->execute())//Αν εκτελεστει και ολα οκ προχωρα
{
    $result_c1 = $stmt_c1->get_result();
    $rows_returned = $result_c1->num_rows;
    $activity_type = array();
    $activity_type_sum = array();
    //store data to arrays
    while($row_data_c1=$result_c1->fetch_assoc())
    {
        array_push($activity_type, $row_data_c1["activityType"]);
        array_push($activity_type_sum, $row_data_c1["counter"]);
    }
    $result_c1->free_result();
    $stmt_c1->close();
    //get data to final array
    for ($rep = 0; $rep <$rows_returned ; $rep++)
    {
        array_push($activity_type, $activity_type_sum[$rep]);
    }
    $_SESSION['activity_num_chart']=$activity_type;
    //print_r($_SESSION['activity_num_chart']);

}
else
{
    $notification = "Error getting user charts info!";
    echo $notification;
    $stmt_c1->close();
    $_SESSION['activity_num_chart']=0;
}


echo json_encode($_SESSION['activity_num_chart']);


?>