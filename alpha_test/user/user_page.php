<?php
session_start();

// Check connection
$dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

//get data from database querries
$user_info= "SELECT username,fname,lname,email,reg_date,role  FROM user WHERE userID = ?";

$stmt_user = $dbconnect->prepare($user_info);
$stmt_user->bind_param('s', $_SESSION['userID']);
if($stmt_user->execute())//Αν εκτελεστει και ολα οκ προχωρα
{
	$result = $stmt_user->get_result();
	$user_info = $result->fetch_array(MYSQLI_NUM);//user_info
	$result->free_result();
	$stmt_user->close();
}
else
{
	$notification = "Error getting user info!";
	echo $notification;
}



/*
KWDIKAS PHP GIA LOG OUT
<?php
session_destroy();
unset($_SESSION['userID']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['verify']);
κλπ κλπ κλπ για τα session variables
header("location: http://localhost/test/index_li.php");
?>

*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
	<title>PANOPTIKON</title>
	<link rel="stylesheet" href="usr_style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body onload="start()"> <!---->
	<div class="pill-nav">
		<button id="hometab" class="tablinks active" onclick="openTab(event, 'home')">Home</button>
		<button class="tablinks" onclick="openTab(event, 'searchtab')">Data Filter</button>
		<button class="tablinks" onclick="openTab(event, 'home')">Profile</button>
		<button class="tablinks" onclick="openTab(event, 'home')">About</button>
		<button class="tablinks" onclick="logout_confirm()">Log Out</button>
	  </div>

<section>
  
  <aside>
    <ul id="tabs" role="toolbar">
		<div id="user">
			<h1><img src="panoptikon.png" alt="logo" width="50" height="35">Panoptikon</h1> 
			<h3 id="name"> <strong>Welcome <?php echo $_SESSION['role'];?></strong> </h3>
			  <hr>
			  <p>Ecological Score:</p>
			  <p>Sign up Period Coverage:</p>
			  <p>File last uploaded at:</p>
			  <div class="upload-btn-wrapper">
				<button id="upload">Upload .json File</button>
				<input type="file" name="myfile" />
			  </div>
			  <!--<button id="upload">Upload .json File </button>
			  <form id="upload" action="/action_page.php">
				<input type="file" id="myFile" name="filename" >
				<input type="submit">
			  </form>-->
			  <h3 id="lboard" position= center> <b>Leaderboard</b> </h3>
						<ol id="lblist">
							<li>Gold</li>
							<li>Silver</li>
							<li>Bronze</li>
						  </ol>
				<h4> You are at place No. </h4>
				<h4> *NUMBER* </h4>
		</div>
    </ul>
</aside>

  
  <article>
	<div class="row">
		<div class="column">
			<h2>This is your total activity in the last month.</h2>
			<div  id='map'> </div>

			<div id="searchload">
				<div id="searchbar">10%</div>
			  </div>
	
			<script src="usr_function.js"> </script>

		</div>

		
		<div class="column">
			<div id="searchtab" class="tabcontent">
						<h3>Sort the map's results by:</h3>

						<p>Year</p>

						<div class="btn-group">
							<div class="dropdown">
								<button onclick="SYearFunction()" class="dropbtn">Starting Year</button>
								<div id="SYeardbtn" class="dropdown-content">
									<a href="#">All</a>
									<a href="#">2020</a>
									<a href="#">2019</a>
									<a href="#">2018</a>
								</div>
							</div>
							<div class="dropdown">
								<button onclick="EYearFunction()" class="dropbtn"> Ending Year</button>
								<div id="EYeardbtn" class="dropdown-content">
									<a href="#">All</a>
									<a href="#">2020</a>
									<a href="#">2019</a>
									<a href="#">2018</a>
								</div>
							</div>
						</div>
				<p>Month</p>

				<div class="btn-group">
					<div class="dropdown">
						<button onclick="SMonthFunction()" class="dropbtn">Starting Month</button>
						<div id="Smonthdbtn" class="dropdown-content">
							<a href="#">All</a>
							<a href="#">January</a>
							<a href="#">February</a>
							<a href="#">March</a>
							<a href="#">April</a>
							<a href="#">May</a>
							<a href="#">June</a>
							<a href="#">July</a>
							<a href="#">August</a>
							<a href="#">September</a>
							<a href="#">October</a>
							<a href="#">November</a>
							<a href="#">December</a>
						</div>
					</div>
					<div class="dropdown">
						<button onclick="EMonthFunction()" class="dropbtn">Ending Month</button>
						<div id="Emonthdbtn" class="dropdown-content">
							<a href="#">All</a>
							<a href="#">January</a>
							<a href="#">February</a>
							<a href="#">March</a>
							<a href="#">April</a>
							<a href="#">May</a>
							<a href="#">June</a>
							<a href="#">July</a>
							<a href="#">August</a>
							<a href="#">September</a>
							<a href="#">October</a>
							<a href="#">November</a>
							<a href="#">December</a>
						</div>
					</div>
				</div>
				<p>Day</p>
				<div class="btn-group">
					<div class="dropdown">
						<button onclick="SDayFunction()" class="dropbtn">Starting Day</button>
						<div id="Sdaydbtn" class="dropdown-content">
							<a href="#">All</a>
							<a href="#">Monday</a>
							<a href="#">Tuesday</a>
							<a href="#">Wednesday</a>
							<a href="#">Thursday</a>
							<a href="#">Friday</a>
							<a href="#">Saturday</a>
							<a href="#">Sunday</a>
						</div>
					</div>
					<div class="dropdown">
						<button onclick="EDayFunction()" class="dropbtn">Ending Day</button>
						<div id="Edaydbtn" class="dropdown-content">
							<a href="#">All</a>
							<a href="#">Monday</a>
							<a href="#">Tuesday</a>
							<a href="#">Wednesday</a>
							<a href="#">Thursday</a>
							<a href="#">Friday</a>
							<a href="#">Saturday</a>
							<a href="#">Sunday</a>
						</div>
					</div>
				</div>
				<p>Time</p>
				<div class="btn-group">
					<div class="dropdown">
						<button onclick="STimeFunction()" class="dropbtn">Starting Time</button>
						<div id="STimedbtn" class="dropdown-content">
							<a href="#">All</a>
							<a href="#">00:00</a>
							<a href="#">01:00</a>
							<a href="#">02:00</a>
							<a href="#">03:00</a>
							<a href="#">04:00</a>
							<a href="#">05:00</a>
							<a href="#">06:00</a>
							<a href="#">07:00</a>
							<a href="#">08:00</a>
							<a href="#">09:00</a>
							<a href="#">10:00</a>
							<a href="#">11:00</a>
							<a href="#">12:00</a>
							<a href="#">13:00</a>
							<a href="#">14:00</a>
							<a href="#">15:00</a>
							<a href="#">16:00</a>
							<a href="#">17:00</a>
							<a href="#">18:00</a>
							<a href="#">19:00</a>
							<a href="#">20:00</a>
							<a href="#">21:00</a>
							<a href="#">22:00</a>
							<a href="#">23:00</a>
						</div>
					</div>
					<div class="dropdown">
						<button onclick="ETimeFunction()" class="dropbtn">Ending Time</button>
						<div id="ETimedbtn" class="dropdown-content">
							<a href="#">All</a>
							<a href="#">00:00</a>
							<a href="#">01:00</a>
							<a href="#">02:00</a>
							<a href="#">03:00</a>
							<a href="#">04:00</a>
							<a href="#">05:00</a>
							<a href="#">06:00</a>
							<a href="#">07:00</a>
							<a href="#">08:00</a>
							<a href="#">09:00</a>
							<a href="#">10:00</a>
							<a href="#">11:00</a>
							<a href="#">12:00</a>
							<a href="#">13:00</a>
							<a href="#">14:00</a>
							<a href="#">15:00</a>
							<a href="#">16:00</a>
							<a href="#">17:00</a>
							<a href="#">18:00</a>
							<a href="#">19:00</a>
							<a href="#">20:00</a>
							<a href="#">21:00</a>
							<a href="#">22:00</a>
							<a href="#">23:00</a>
						</div>
					</div>
				</div>
				<div class="dropdown">
					<button onclick="ActivFunction()" class="dropbtn">Activity</button>
					<div id="Activdbtn" class="dropdown-content">
							<a href="#">All</a>
							<a href="#">WALKING</a>
							<a href="#">STILL</a>
					</div>
				</div>

				<button id="searchbtn" onclick="move()">Search </button>

				
				
				<script src="usr_function.js"> </script>

			</div>
	<script src="usr_function.js"> </script>
  </article>

    
</section>



<div class="footer">
	<div class="footer_content">
	  <div class="footer_section about">
		<h1 class="logo_text"><img src="panoptikon.png" alt="logo" width="50" height="35"><span>Panoptikon</span></h1>
		<p>
			Panoptikon is a crowdsourcing website, centered around the city of Patras and Rion.
		  <br>Developed for a project in the Computer Engineering and Informatics Department in the University of Patras.<br>
		  <!--Feal free to visit:
		  <a href="services.php">Services</a>
		  for further info.-->
		</p>
		<div class="contact">
		  <span><i class="fa fa-phone"></i> &nbsp; 6975804653</span>
		  <span><i class="fa fa-envelope"></i> &nbsp; stauropan@gmail.com</span>
		</div>
		<div class="socials">
		  <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
		  <a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a>
		  <a href="https://www.twitter.com/"><i class="fa fa-twitter"></i></a>
		  <a href="https://www.youtube.com/"><i class="fa fa-youtube"></i></a>
		  <a href="https://https://github.com/Vazeagle/Web-Crowdsourcing-Project"><i class="fa fa-github"></i></a>
		</div>
	  </div>
	  <div class="footer_section links">
		<h2>Quick Links</h2>
		<br>
		<ul>
		  <a href="#"><li>About</li></a>
		  <a href="#"><li>Profile</li></a>
		  <a href="#"><li>Terms and Conditions</li></a>
		</ul>
	  </div>
	  <div class="footer_section contact_form">
		<h2>Contact us</h2>
		<br>
		<form action="index.html" method="post">
		  <input type="email" name="email" class="text_input contact_input" placeholder="Your email address..."></input>
		  <textarea name="message" class="text_input contact_input" placeholder="Your message..."></textarea> <!--  This one right here has to limit its length and width size with JavaScript. -->
		  <!-- This one right below will be usefull. -->
		  <!-- https://stackoverflow.com/questions/4459610/set-maxlength-in-html-textarea -->
		  <button type="submit" name="button" class="btn btn_big contact_btn">
			<i class="fa fa-envelope"></i>
			Send
		  </button>
		</form>
	  </div>
	</div>
	<div class="footer_copyright">
	  &copy; panoptikon.com | 
	</div>
  </div>

</body>
</html>
