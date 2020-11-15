<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    date_default_timezone_set('Europe/Athens');
    $cur_date_Y_m =explode("-", date('Y-m', time()));
    $cur_year=$cur_date_Y_m[0];
    $cur_month=$cur_date_Y_m[1];

//if (isset($_POST['login_btn']))//ΑΝ πατηθει το κουμπι login na arxizei tote gia pio grhgora
//ΑΛΛΑ ΘΑ ΧΡΕΙΑΣΤΕΙ REQUIRE STO NDEX_LI
//{}

    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project");


    //get data from database querries
    $user_page_heatmap_filter= "SELECT latitude,longitude FROM locations WHERE userID = ? AND YEAR(timestampMs) = ? AND MONTH(timestampMs)= ? ";


    $stmt_hp = $dbconnect->prepare($user_page_heatmap_filter);
    $stmt_hp->bind_param('sss', $_SESSION['userID'], $cur_year, $cur_month);
    if($stmt_hp->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
        $res_home_heat = $stmt_hp->get_result();
        $rows_returned_hp = $res_home_heat->num_rows;
        $loc_lat_home = array();
        $loc_long_home = array();
        //store data to arrays
        while($row_data_home=$res_home_heat->fetch_assoc())
		{
			array_push($loc_lat_home, $row_data_home["latitude"]);
			array_push($loc_long_home, $row_data_home["longitude"]);
		}
        $res_home_heat->free_result();
        $stmt_hp->close();
        //get data to final array
        for ($rep = 0; $rep <$rows_returned_hp ; $rep++)
		{
			array_push($loc_lat_home, $loc_long_home[$rep]);
		}
		$_SESSION['lat_long_heatmap_user_page']=$loc_lat_home;

    }
    else
    {
        $notification = "Error getting user charts info!";
        $stmt_hp->close();
    }
    echo json_encode($_SESSION['lat_long_heatmap_user_page']);

?>