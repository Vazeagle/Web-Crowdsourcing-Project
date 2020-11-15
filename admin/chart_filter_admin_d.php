<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }


    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project");

    //get data from database querries
    $actType_sum_per_dayofweek_query= "SELECT DAYNAME(timestampMs) AS weekday, COUNT(*) AS activities_sum FROM sub_activity GROUP BY DAYOFWEEK(timestampMs)";

    $stmt_d = $dbconnect->prepare($actType_sum_per_dayofweek_query);
    //$stmt_c1->bind_param('sss', $_SESSION['adminID'], $starting_date, $ending_date);
    if($stmt_d->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
        $result_d = $stmt_d->get_result();
        $rows_returned_d = $result_d->num_rows;
        $dayofweek_d = array();
        $activity_type_sum_d = array();
        //store data to arrays
        while($row_data_d=$result_d->fetch_assoc())
		{
			array_push($dayofweek_d, $row_data_d["weekday"]);
			array_push($activity_type_sum_d, $row_data_d["activities_sum"]);
		}
        $result_d->free_result();
        $stmt_d->close();
        //get data to final array
        for ($rep = 0; $rep <$rows_returned_d ; $rep++)
		{
			array_push($dayofweek_d, $activity_type_sum_d[$rep]);
		}
        $_SESSION['activity_sum_per_dayofweek']=$dayofweek_d;
        //print_r($_SESSION['activity_num_chart']);

    }
    else
    {
        $notification = "Error getting user charts info!";
        //echo $notification;
        $stmt_d->close();
    }
    echo json_encode($_SESSION['activity_sum_per_dayofweek']);

?>