<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }


    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project");

    //get data from database querries
    $actType_sum_per_month_query= "SELECT MONTHNAME(timestampMs) AS month, COUNT(*) AS activities_sum FROM sub_activity GROUP BY MONTH(timestampMs)";

    $stmt_c = $dbconnect->prepare($actType_sum_per_month_query);
    //$stmt_c1->bind_param('sss', $_SESSION['adminID'], $starting_date, $ending_date);
    if($stmt_c->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
        $result_c = $stmt_c->get_result();
        $rows_returned_c = $result_c->num_rows;
        $month_c = array();
        $activity_type_sum_c = array();
        //store data to arrays
        while($row_data_c=$result_c->fetch_assoc())
		{
			array_push($month_c, $row_data_c["month"]);
			array_push($activity_type_sum_c, $row_data_c["activities_sum"]);
		}
        $result_c->free_result();
        $stmt_c->close();
        //get data to final array
        for ($rep = 0; $rep <$rows_returned_c ; $rep++)
		{
			array_push($month_c, $activity_type_sum_c[$rep]);
		}
        $_SESSION['activity_sum_per_month']=$month_c;
        //print_r($_SESSION['activity_num_chart']);

    }
    else
    {
        $notification = "Error getting user charts info!";
        //echo $notification;
        $stmt_c->close();
    }
    echo json_encode($_SESSION['activity_sum_per_month']);

?>