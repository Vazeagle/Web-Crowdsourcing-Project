<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}

$dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;
date_default_timezone_set('Europe/Athens');
$date_Y_m = date ('Y-m', time());
$date_time=$date_Y_m ."-01";//ημερομηνια με βαση το table eco αφου δεν μας νοιζει η ημερα

//get current date info to know the last 12months
$date_splited=explode("-", $date_Y_m);
$cur_year=$date_splited[0];
$cur_month=$date_splited[1];
$old_year=$cur_year-1;
$latest12months_chart = array();
$latest12months_year_chart = array();

if($cur_month=='01')
{
	//months
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='02')
{
	//months
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='03')
{
	//months
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='04')
{
	//months
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='05')
{
	//months
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='06')
{
	//months
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='07')
{
	//months
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='08')
{
	//months
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='09')
{
	//months
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='10')
{
	//months
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='11')
{
	//months
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	array_push($latest12months_chart,'January');
	///year
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$old_year);
	array_push($latest12months_year_chart,$cur_year);
}
elseif($cur_month=='12')
{
	//months
	array_push($latest12months_chart,'January');
	array_push($latest12months_chart,'February');
	array_push($latest12months_chart,'March');
	array_push($latest12months_chart,'April');
	array_push($latest12months_chart,'May');
	array_push($latest12months_chart,'June');
	array_push($latest12months_chart,'July');
	array_push($latest12months_chart,'August');
	array_push($latest12months_chart,'September');
	array_push($latest12months_chart,'October');
	array_push($latest12months_chart,'November');
	array_push($latest12months_chart,'December');
	///year
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
	array_push($latest12months_year_chart,$cur_year);
}




	$user_12month_eco_query= "SELECT ecoscore, activity_date FROM eco WHERE userID = ? AND activity_date >= (SELECT DATE_ADD(?, INTERVAL -12 MONTH)) AND activity_date <= ?  ORDER BY ? ASC";
	$stmt_12eco = $dbconnect->prepare($user_12month_eco_query);
	$date_time2=$date_time;
	$date_time3=$date_time;
	$stmt_12eco->bind_param('ssss', $_SESSION['userID'],$date_time,$date_time2,$date_time3);
	if($stmt_12eco->execute())//Αν εκτελεστει και ολα οκ προχωρα
	{
		$result_12ecoscore_and_12m = $stmt_12eco->get_result();
		$month_data_num = $result_12ecoscore_and_12m->num_rows;

		$_SESSION['last12m']=$latest12months_chart;	//mallon oxi anagkaioi gia session variables
		$_SESSION['last12m_wYear']=$latest12months_year_chart;
		$latest12_chart_ready = array();
		for($i=0; $i<12; $i++)
		{
			array_push($latest12_chart_ready,($latest12months_year_chart[$i] ."-". $latest12months_chart[$i]));
		}
		$_SESSION['chart_Y_m']=$latest12_chart_ready; //ΠΕΡΙΈΧΕΙ ΕΤΟΣ-ΜΗΝΑ  ΤΑ 12 ΤΕΛΕΥΤΑΙΑ ΜΕ ΒΑΣΗ ΤΟ ΤΡΕΧΟΝ ΕΤΟΣ ΚΑΙ ΜΗΝΑ
		//empty arrays
		unset($latest12_chart_ready);
		unset($latest12months_chart);
		unset($latest12months_year_chart);
		//---------------------------------------------------------------------------------------------------------------------------------
		//save returned data to array
		$last12months_wYear = array();
		$ecoscore_oflast12months = array();
		while($row_date=$result_12ecoscore_and_12m->fetch_assoc())
		{
			array_push($ecoscore_oflast12months, $row_date["ecoscore"]);
			array_push($last12months_wYear, $row_date["activity_date"]);
		}
		if($month_data_num!=0)//Αν επεστρεψε καποιο row με ecoscore και κάποιο μηνα
		{
			if($month_data_num==12)//Αν εχουμε πάρει ακριβώς 12 μηνες
			{
				$stmt_12eco->close();
				$_SESSION['user_12month_ecoscore']=$ecoscore_oflast12months;
			}
			else	//an einia ligotera apo 12 ta rows bres pou antoistoixoyn kai emfaniseta me seira
			{
				$stmt_12eco->close();
				$latest12_date_chart_ready = array();
				$latest12_ecoscore_ready = array();
				for ($y = 0; $y < sizeof($last12months_wYear); $y++)
				{
					$date_split=explode("-", $last12months_wYear[$y]);
					if($date_split[1]=='01'){$month_d="January";}
					elseif($date_split[1]=='02'){$month_d="February";}
					elseif($date_split[1]=='03'){$month_d="March";}
					elseif($date_split[1]=='04'){$month_d="April";}
					elseif($date_split[1]=='05'){$month_d="May";}
					elseif($date_split[1]=='06'){$month_d="June";}
					elseif($date_split[1]=='07'){$month_d="July";}
					elseif($date_split[1]=='08'){$month_d="August";}
					elseif($date_split[1]=='09'){$month_d="September";}
					elseif($date_split[1]=='10'){$month_d="October";}
					elseif($date_split[1]=='11'){$month_d="November";}
					else{$month_d="December";}
					$specific_year_month=$date_split[0]."-".$month_d;
					//array_push($latest12_date_chart_ready,$specific_year_month)
					for($z=0; $z<12; $z++)
					{
						if($_SESSION['chart_Y_m'][$z]==$specific_year_month)
						{
							array_push($latest12_ecoscore_ready,$ecoscore_oflast12months[$y]);
						}
						else
						{
							array_push($latest12_ecoscore_ready,0);

						}
					}
				}
				//$latest12_date_chart_ready
				$_SESSION['user_12month_ecoscore']=$latest12_ecoscore_ready;//exei pinaka me ta dedomena apo 12 h ligoterous mhnes
			}
		}
		else
		{
			$ecoscore_oflast12months_2 = array();
			for ($x = 0; $x < 12; $x++)
			{
				array_push($ecoscore_oflast12months_2, 0);
			}
			$result_12ecoscore_and_12m->free_result();
			$stmt_12eco->close();
			$_SESSION['user_12month_ecoscore']=$ecoscore_oflast12months_2;
		}	
	}
	else
	{
		$notification = "Error getting 12m data!";
		echo $notification;
		$ecoscore_oflast12months = array();
		for ($x = 0; $x < 12; $x++)
		{
			array_push($ecoscore_oflast12months, 0);
		}
		$_SESSION['user_12month_ecoscore']=$ecoscore_oflast12months;
	}
	$final_Data= array();
	$final_Data=$_SESSION['chart_Y_m'];
	for ($f = 0; $f < 12; $f++)
		{
			array_push($final_Data, $_SESSION['user_12month_ecoscore'][$f]);
		}
		$_SESSION['final_12m_+ecoscore_chart']=$final_Data;
	
		echo json_encode($_SESSION['final_12m_+ecoscore_chart']);
	?>