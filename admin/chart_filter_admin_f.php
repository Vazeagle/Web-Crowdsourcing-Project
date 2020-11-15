<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }


    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project");

    //get data from database querries
    $actType_sum_per_year_query= "SELECT YEAR(timestampMs) AS year, COUNT(*) AS activities_sum FROM sub_activity GROUP BY YEAR(timestampMs)";

    $stmt_f = $dbconnect->prepare($actType_sum_per_year_query);
    //$stmt_c1->bind_param('sss', $_SESSION['adminID'], $starting_date, $ending_date);
    if($stmt_f->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
        $result_f = $stmt_f->get_result();
        $rows_returned_f = $result_f->num_rows;
        $year_f = array();
        $activity_type_sum_f = array();
        //store data to arrays
        while($row_data_f=$result_f->fetch_assoc())
		{
			array_push($year_f, $row_data_f["year"]);
			array_push($activity_type_sum_f, $row_data_f["activities_sum"]);
		}
        $result_f->free_result();
        $stmt_f->close();
        //get data to final array
        for ($rep = 0; $rep <$rows_returned_f ; $rep++)
		{
			array_push($year_f, $activity_type_sum_f[$rep]);
		}
        $_SESSION['activity_sum_per_year']=$year_f;
        //print_r($_SESSION['activity_num_chart']);

    }
    else
    {
        $notification = "Error getting user charts info!";
        //echo $notification;
        $stmt_f->close();
    }
    echo json_encode($_SESSION['activity_sum_per_year']);

?>