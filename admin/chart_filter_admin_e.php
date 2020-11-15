<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }


    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project");

    //get data from database querries
    $actType_sum_per_hour_query= "SELECT HOUR(timestampMs) AS hour, COUNT(*) AS activities_sum FROM sub_activity GROUP BY HOUR(timestampMs)";

    $stmt_e = $dbconnect->prepare($actType_sum_per_hour_query);
    //$stmt_c1->bind_param('sss', $_SESSION['adminID'], $starting_date, $ending_date);
    if($stmt_e->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
        $result_e = $stmt_e->get_result();
        $rows_returned_e = $result_e->num_rows;
        $hour_e = array();
        $activity_type_sum_e = array();
        //store data to arrays
        while($row_data_e=$result_e->fetch_assoc())
		{
			array_push($hour_e, $row_data_e["hour"]);
			array_push($activity_type_sum_e, $row_data_e["activities_sum"]);
		}
        $result_e->free_result();
        $stmt_e->close();
        //get data to final array
        for ($rep = 0; $rep <$rows_returned_e ; $rep++)
		{
			array_push($hour_e, $activity_type_sum_e[$rep]);
		}
        $_SESSION['activity_sum_per_hour']=$hour_e;
        //print_r($_SESSION['activity_num_chart']);

    }
    else
    {
        $notification = "Error getting user charts info!";
        //echo $notification;
        $stmt_e->close();
    }
    echo json_encode($_SESSION['activity_sum_per_hour']);

?>