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
$user_heatmap_filter= "SELECT latitude,longitude FROM locations WHERE userID = ? AND timestampMs >= ? AND timestampMs<= ?";


$stmt_c4 = $dbconnect->prepare($user_heatmap_filter);
$stmt_c4->bind_param('sss', $_SESSION['userID'], $starting_date, $ending_date);
if($stmt_c4->execute())//Αν εκτελεστει και ολα οκ προχωρα
{
    $result_c4 = $stmt_c4->get_result();
    $rows_returned_d = $result_c4->num_rows;
    $loc_lat = array();
    $loc_long = array();
    //store data to arrays
    while($row_data_c4=$result_c4->fetch_assoc())
    {
        array_push($loc_lat, $row_data_c4["latitude"]);
        array_push($loc_long, $row_data_c4["longitude"]);
    }
    $result_c4->free_result();
    $stmt_c4->close();
    //get data to final array
    for ($rep = 0; $rep <$rows_returned_d ; $rep++)
    {
        array_push($loc_lat, $loc_long[$rep]);
    }
    $_SESSION['lat_long_heatmap_filter']= $loc_lat;

}
else
{
    $notification = "Error getting user charts info!";
    $stmt_c4->close();
}
echo json_encode($_SESSION['lat_long_heatmap_filter']);

?>