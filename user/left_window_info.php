<?php

require_once(__DIR__.'/../server/jsonDecoder-upload.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
$user_id=$_SESSION['userID'];
////////////////////////////////////////////
//this months eco score
date_default_timezone_set('Europe/Athens');
$date_Y_m = date ('Y-m', time());
$date_time=$date_Y_m ."-01";//ημερομηνια με βαση το table eco αφου δεν μας νοιζει η ημερα


$user_cur_eco_query= "SELECT ecoscore  FROM eco WHERE userID = ? AND activity_date = ? ";
$stmt_eco = $dbconnect->prepare($user_cur_eco_query);
$stmt_eco->bind_param('ss', $_SESSION['userID'], $date_time);
if($stmt_eco->execute())//Αν εκτελεστει και ολα οκ προχωρα
{
	$result_cur_ecoscore = $stmt_eco->get_result();
	$data_num_returned = $result_cur_ecoscore->num_rows;
	if($data_num_returned!=0)//Αν επεστρεψε καποιο ecoscore για τον τρέχοντα μήνα
	{
		$user_cur_ecoscore = $result_cur_ecoscore->fetch_array(MYSQLI_NUM);
		$result_cur_ecoscore->free_result();
		$stmt_eco->close();
		$_SESSION['user_cur_month_ecoscore']=$user_cur_ecoscore[0] ."%";
	}
	else
	{
		$result_cur_ecoscore->free_result();
		$stmt_eco->close();
		$_SESSION['user_cur_month_ecoscore']=0;
	}
	
}
else
{
	$notification = "Error getting user's this month eco score!";
	echo $notification;
	$_SESSION['user_cur_month_ecoscore']=0;
}

//eco_12month last data
require('eco_12month.php');


//Εγγραφες χρήστη
$user_time_period= "SELECT MAX(timestampMs),MIN(timestampMs)  FROM locations WHERE userID = ?";
$stmt_data_time = $dbconnect->prepare($user_time_period);
$stmt_data_time->bind_param('s', $_SESSION['userID']);
if($stmt_data_time->execute())//Αν εκτελεστει και ολα οκ προχωρα
{
	$result_time_period = $stmt_data_time->get_result();
	$user_data_period = $result_time_period->fetch_array(MYSQLI_NUM);
	$result_time_period->free_result();
	$stmt_data_time->close();
	$_SESSION['user_last_data_period']=$user_data_period[0];
	$_SESSION['user_first_data_period']=$user_data_period[1];
	
}
else
{
	$notification = "Error getting user info!";
	echo $notification;
	$_SESSION['user_first_data_period']="";
	$_SESSION['user_last_data_period']="";
}

//last file uploaded
$user_last_upload= "SELECT MAX(uploadDate) FROM map_data WHERE userID = ?";
$stmt_last_file = $dbconnect->prepare($user_last_upload);
$stmt_last_file->bind_param('s', $_SESSION['userID']);
if($stmt_last_file->execute())//Αν εκτελεστει και ολα οκ προχωρα
{
	$last_upload = $stmt_last_file->get_result();
	$num_row_returned_last_upload_Date = $last_upload->num_rows;
	$last_upload_date = $last_upload->fetch_array(MYSQLI_NUM);
	$last_upload->free_result();
	$stmt_last_file->close();
	if($last_upload_date[0]=="")
	{
		$_SESSION['user_last_upload_date']="NaN";
		
	}
	else
	{
		$_SESSION['user_last_upload_date']=$last_upload_date[0];
	}
	
}
else
{
	$notification = "Error getting user info!";
	echo $notification;
	$_SESSION['user_last_upload_date']="NaN";
}

//TOP 3 AND USER LEADERBOARD
$leaderboard_query = "SELECT user.fname,user.lname,user.userID,eco.ecoscore FROM user INNER JOIN eco ON user.userID=eco.userID WHERE eco.activity_date=? ORDER BY eco.ecoscore DESC";
$stmt_eco_leaderboard = $dbconnect->prepare($leaderboard_query);
$stmt_eco_leaderboard->bind_param('s', $date_time);
if($stmt_eco_leaderboard->execute())//Αν εκτελεστει και ολα οκ προχωρα
{
	$result_leaderboard = $stmt_eco_leaderboard->get_result();
	$array_leaderboard_size = $result_leaderboard->num_rows;
	$Fname_ar = array();
	$Lname_ar = array();
	$userID_ar = array();
	$ecoscore_ar = array();
	while($row=$result_leaderboard->fetch_assoc())
	{
		//echo $row["fname"]." ";
		array_push($Fname_ar, $row["fname"]);
		array_push($Lname_ar, $row["lname"]);
		array_push($userID_ar, $row["userID"]);
		array_push($ecoscore_ar, $row["ecoscore"]);

	}
	$place1="-";
	$place2="-";
	$place3="-";
	$user_place=0;

	if($array_leaderboard_size==1)//Αν επιστρεψει ενα χρηστη μονο
	{
		if($userID_ar[0]==$user_id)
		{
			$user_place=1;
		}
		else
		{
			$user_place=0;
		}
		$lname_split = str_split($Lname_ar[0]);
		$place1=$Fname_ar[0] ." ". $lname_split[0] .". ". $ecoscore_ar[0] ."%";
		$place2="-";
		$place3="-";
	}
	elseif($array_leaderboard_size==2)//Αν επιστρέψει 2 χρηστες
	{
		if($userID_ar[0]==$user_id)
		{
			$user_place=1;
		}
		elseif($userID_ar[1]==$user_id)
		{
			$user_place=2;
		}
		else
		{
			$user_place=0;
		}
		$lname1_split = str_split($Lname_ar[0]);
		$place1=$Fname_ar[0] ." ". $lname1_split[0] .". ". $ecoscore_ar[0] ."%";
		$lname2_split = str_split($Lname_ar[1]);
		$place2=$Fname_ar[1] ." ". $lname2_split[0] .". ". $ecoscore_ar[1] ."%";
		$place3="-";
	}
	elseif($array_leaderboard_size>=3)//Αν επιστρέψει >=3 χρηστες
	{
		$lname1_split = str_split($Lname_ar[0]);
		$place1=$Fname_ar[0] ." ". $lname1_split[0] .". ". $ecoscore_ar[0] ."%";
		$lname2_split = str_split($Lname_ar[1]);
		$place2=$Fname_ar[1] ." ". $lname2_split[0] .". ". $ecoscore_ar[1] ."%";
		$lname3_split = str_split($Lname_ar[2]);
		$place3=$Fname_ar[2] ." ". $lname3_split[0] .". ". $ecoscore_ar[2] ."%";

		for ($rep = 0; $rep < sizeof($userID_ar); $rep++)
		{
			if(strcmp($userID_ar[$rep], $user_id)==0)//equal
			{
				$user_place=($rep+1);
			}
			
		}
	}
	else
	{
		$place1="-";
		$place2="-";
		$place3="-";
		$user_place=0;
	}

	$_SESSION['leaderboard_1']=$place1;
	$_SESSION['leaderboard_2']=$place2;
	$_SESSION['leaderboard_3']=$place3;
	$_SESSION['userPlace']=$user_place;
	$result_leaderboard->free_result();
	$stmt_eco_leaderboard->close();

	//empty array for new data
	if(!(empty($Fname_ar))) //an to ena den einai adeio tote einai ola gemata
	{
		unset($Fname_ar);
		unset($Lname_ar);
		unset($userID_ar);
		unset($ecoscore_ar);
		//$Fname_ar = array();
		//$Lname_ar = array();
		//$userID_ar = array();
		//$ecoscore_ar = array();
	}
}
else
{
	$_SESSION['leaderboard_1']="-";
	$_SESSION['leaderboard_2']="-";
	$_SESSION['leaderboard_3']="-";
	$_SESSION['userPlace']=0;
	$notification = "Error getting user info!";
	echo $notification;
	$stmt_eco_leaderboard->close();
}
////////////////////////////////
?>