<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}

//$_SESSION['userInfo'] has all the data of user as username fname lname email regdate role

//User Log Out
if (isset($_POST["log_out"]))
{
	$_SESSION['log_out_flag']= true; 
	unset($_SESSION['userID']);
	unset($_SESSION['msg']);
	header("location: http://localhost/web_project/index_li.php");
}
require('available_years.php');


					if(empty($_POST["syear"]) || empty($_POST["eyear"]) ||	empty($_POST["smonth"]) || empty($_POST["emonth"]))
					{
						if(isset($_POST["search_filter"]))
						{
							echo "Please select valid Year and Month!";
						}
					}
					else{
						if(isset($_POST["search_filter"]))
						{
							require('charts_data_filter_a.php');
							$myfile = fopen("empty.txt", "w") or die("Unable to open file!");
							$txt = $_POST['syear'] . "\n" . $_POST['eyear'] . "\n" . $_POST['smonth'] . "\n" . $_POST['emonth'];
							fwrite($myfile, $txt);
							fclose($myfile);
							require('charts_data_filter_b.php');
							require('charts_data_filter_c.php');
							header("location: http://localhost/web_project/user/filter_results.php");
						}
					
					}
					?>





<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<title>PANOPTIKON</title>
	<link rel="stylesheet" href="usr_style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body> 

<div class="pill-nav">
<button class="tablinks" onclick="homeTab()">Home</button>
		<button class="tablinks active" onclick="dataTab()">Data Filter</button>
		<button class="tablinks" onclick="upTab()">Upload</button>
		<button class="tablinks" onclick="profileTab()">Profile</button>
		<button class="tablinks" onclick="aboutTab()">About</button>
		

	  </div>

	  
	  <script>
			function homeTab()
			{
				window.location.replace("http://localhost/web_project/user/user_page.php");
			}
			function dataTab()
			{
					window.location.replace("http://localhost/web_project/user/data_filter.php");
				}
				function upTab()
			{
					window.location.replace("http://localhost/web_project/user/upload.php");
				}
				function profileTab()
			{
					window.location.replace("http://localhost/web_project/user/user_profile.php");
				}

				function aboutTab()
			{
					window.location.replace("http://localhost/web_project/user/about_page.php");
				}
		</script>


<section>
  
  <aside>
    <ul id="tabs" role="toolbar">
		<div id="user">
			<h1><img src="panoptikon.png" alt="logo" width="50" height="35">Panoptikon</h1> 
			<h3 id="name"> <strong>Welcome <?php echo $_SESSION['userInfo'][5] .", " . $_SESSION['userInfo'][0];?></strong> </h3>
      <form  action = "" method="post">
		<button name="log_out" id="logout" >Log Out</button>
		</form>
			  <hr>
			  <p>Ecological Score: <?php echo $_SESSION['user_cur_month_ecoscore'];?></p>
			  <p>Sign up Period Coverage: <?php echo $_SESSION['user_first_data_period'] ."-" . $_SESSION['user_last_data_period'];?></p>
			  <p>File last uploaded at:  <?php echo $_SESSION['user_last_upload_date'];?></p>
			  <h3 id="lboard" position= center> <b>Leaderboard</b> </h3>
						<ol id="lblist">
							<li><?php echo $_SESSION['leaderboard_1']?></li>
							<li><?php echo $_SESSION['leaderboard_2']?></li>
							<li><?php echo $_SESSION['leaderboard_3']?></li>
						  </ol>
				<h4> You are at place No. <?php echo $_SESSION['userPlace']?></h4>
		</div>
    </ul>
</aside>

  
  <article>
	  <div id="searchtab" class="tabcontent">
		  <div id="filparam">
		  <h2>Sort the map's results by:</h2>
		  <script>
					$.post('available_years.php',
										function(result){
										var dtYear = jQuery.parseJSON(result);
										var yearsAv = [];
										for (var i = 0; i < Object.values(dtYear).length; i++) {
											yearsAv.push(Object.values(dtYear)[i]);
										}
											var optionsStart = "";
											optionsStart += "<option disabled selected>Starting Year</option>";
											for(var year = Object.values(yearsAv)[0] ; year <=Object.values(yearsAv)[Object.values(yearsAv).length-1]; year++){
												optionsStart += "<option>"+ year +"</option>";
													}
										  
										  document.getElementById("filtersYearS").innerHTML = optionsStart;
										  var optionsEnd = "";
										  optionsEnd += "<option disabled selected>Ending Year</option>";
											for(var year = Object.values(yearsAv)[0] ; year <=Object.values(yearsAv)[Object.values(yearsAv).length-1]; year++){
												optionsEnd += "<option>"+ year +"</option>";
													}
										  
										  document.getElementById("filtersYearE").innerHTML = optionsEnd;});
										

				</script>
		  <!--<form id="sel-filter" action = "" method="post">-->
		  <form  action = "" method="post">
									<p>Year</p>
      
					<select id="filtersYearS" name="syear">
						
					</select>
					<select id="filtersYearE" name="eyear">
					
					</select>
					
      
					<p>Month</p>
					<select id="filters" name="smonth" >
						<option value="" disabled selected>Starting Month</option>
						<option value="january">January</option>
						<option value="february">February</option>
						<option value="march">March</option>
						<option value="april">April</option>
						<option value="may">May</option>
						<option value="june">June</option>
						<option value="july">July</option>
						<option value="august">August</option>
						<option value="september">September</option>
						<option value="october">October</option>
						<option value="november">November</option>
						<option value="december">December</option>
					</select>
					<select id="filters" name="emonth">
						<option value="" disabled selected>Ending Month</option>
						<option value="january">January</option>
						<option value="february">February</option>
						<option value="march">March</option>
						<option value="april">April</option>
						<option value="may">May</option>
						<option value="june">June</option>
						<option value="july">July</option>
						<option value="august">August</option>
						<option value="september">September</option>
						<option value="october">October</option>
						<option value="november">November</option>
						<option value="december">December</option>
					</select>
					<p> </p>
					
					<button id="searchbtn" name="search_filter">Search </button>
					</form>
					

					
			</div>

	</div>

  </article>
  

    
</section>



<footer class="footer-distributed">

			<div class="footer-left">
          <h1 class="logo_text"><img src="panoptikon.png" alt="logo" width="50" height="35"><span>Panoptikon</span></h1>
        
        <p class="footer-company-about">
					Panoptikon is a crowdsourcing website, centered around the city of Patras and Rion.
          <br>
          Developed for a project in the Computer Engineering and Informatics Department in the University of Patras.<br>
          </p>
        <p class="footer-company-name">© 2020 Panoptikon Crowdsourcing</p>
				<div class="footer-icons">
					 <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
		  <a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a>
		  <a href="https://www.twitter.com/"><i class="fa fa-twitter"></i></a>
		  <a href="https://www.youtube.com/"><i class="fa fa-youtube"></i></a>
		  <a href="https://https://github.com/Vazeagle/Web-Crowdsourcing-Project"><i class="fa fa-github"></i></a>

				
			</div>
        </div>
        

			<div class="footer-center">
        <h2>Quick Links</h2>
  <p class="footer-links">
    
		<br>
		  <a href="#">Home</a>
		  <a href="#">About</a>
		  <a href="#">Terms and Conditions</a>
		

				
				
			</div>
			<div class="footer-right">
				<h2>Contact us</h2>
		<br>
		  <input type="email" name="email" class="footer-contact" placeholder="Your email address..."></input>
		  <textarea name="message" class="footer-contact" placeholder="Your message..."></textarea> <!--  This one right here has to limit its length and width size with JavaScript. -->
		  <!-- This one right below will be usefull. -->
		  <!-- https://stackoverflow.com/questions/4459610/set-maxlength-in-html-textarea -->
		  <button type="submit" name="button" class="footer-sendbtn btn_big">
			<i class="fa fa-envelope"></i>
			Send
		  </button>
      <span><i class="fa fa-phone"></i> &nbsp; 6975804653</span>
      
				</div>
			</div>
		</footer>
  <script src="usr_function.js"></script>
</body>
</html>
