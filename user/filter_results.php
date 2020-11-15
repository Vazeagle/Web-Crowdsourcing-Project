<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}

//$_SESSION['userInfo'] has all the data of user as username fname lname email regdate role
//require('left_window_info.php');
//User Log Out
if (isset($_POST["log_out"]))
{
	$_SESSION['log_out_flag']= true; 
	unset($_SESSION['userID']);
	unset($_SESSION['msg']);
	header("location: http://localhost/web_project/index_li.php");
}
// print_r($_SESSION["activity_num_chart"]);
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
	<script src="leaflet.heat.js"></script>
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

				<div class="row">
					<div class="column">
						<h2 id="results">This is your activity for your filters.</h2>
						<div  id='mapDT'> </div>

						<script>
						

							var mapDT = L.map('mapDT').setView([0,0],1);

							L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=nQNGtBIpgHqmOzDa5Eo7', {
								attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
							}).addTo(mapDT);

							mapDT.setView ([38.2462420, 21.7350847], 11);

							$.post('charts_data_filter_heatmap.php',
								function(result){
									console.log(result);
									var heatDT = jQuery.parseJSON(result);
									var dataLatitude = [];
									var dataLongtitude = [];
									for (var i = 0; i < (Object.values(heatDT).length)/2; i++) {
										dataLatitude.push(Object.values(heatDT)[i]);
										dataLongtitude.push(Object.values(heatDT)[i + ((Object.values(heatDT).length)/2)]);
									}
									var ar1 = [];
									var ar2 = [];
									for(var x=0; x<dataLatitude.length; x++){
										ar1.push(dataLatitude[x]);
										ar1.push(dataLongtitude[x]);
										ar1.push(1);
										ar2.push(ar1);
										var ar1 = [];
									}
									heatMap = new L.heatLayer(ar2, {radius: 15}).addTo(mapDT);
								});
						
						</script>
            
            <p> </p>
<button id="newsearch" name="" onclick="dataTab()">New Search </button>
					</div>

					
					<div class="column">
					
        
          <div id="charts" class="chart-container">
            <canvas id="perc-per-type"></canvas>
			<script>
				//Function for random colors on the charts
				function random_rgba() {
					var o = Math.round, r = Math.random, s = 255;
					return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + 1 + ')';
					}
				function rgba_x_number_array(number) {
					var rgba_array = [];
					for (var i = 0; i < number; i++) {
							rgba_array.push(random_rgba());
						}
					return rgba_array;
					}

					//Charts for Data Filter
				//Chart for percentage of each type of activity --> data->instances of each activity
				$.post('charts_data_filter_a.php',
										function(result){
											// console.log(result);
										var res1 = jQuery.parseJSON(result);
										var activPercArray = [];
										var activityArray = [];
										for (var i = 0; i < (Object.values(res1).length)/2; i++) {
											activityArray.push(Object.values(res1)[i]);
											activPercArray.push(Object.values(res1)[i + ((Object.values(res1).length)/2)]);
										}
																	
					var ctx1 = document.getElementById('perc-per-type').getContext('2d');
					var chart_1 = new Chart(ctx1, {
					type: 'pie',
					data: {
						labels: Object.values(activityArray),
						datasets: [{
							label: '% of Activities',
							data: Object.values(activPercArray),
							backgroundColor: rgba_x_number_array(Object.values(activityArray).length),
									borderColor: 'white',
									borderWidth: 1
						}]
					},
					options: {
						legend: {
						position: 'left'
						},
						title: {
						display: true,
						text: '% of each activity type'
						},
						scales: {
						yAxes: [{
							gridLines: {
							display: false,
							},
							ticks: {
							display: false
							}
						}]
						}
					}
					});
				});
			</script>
            <canvas id="perc-per-hour"></canvas>
			<script>
				//Chart for actvity per hour --> x=hour, y=activity
				$.post('charts_data_filter_b.php',
										function(result){
											// console.log(result);
											var res2 = jQuery.parseJSON(result);
											var hourPercArray = [];
											var activityArrayH = [];
											for (var i = 0; i < Object.values(res2)[0].length; i++) {
												hourPercArray.push(Object.values(res2)[0][i]);
												activityArrayH.push(Object.values(res2)[1][i]);
											}
										
											var ctx2 = document.getElementById('perc-per-hour').getContext('2d');
											var chart_2 = new Chart(ctx2, {
												type: 'bar',
												data: {
													labels: Object.values(hourPercArray),
													datasets: [{
														data: Object.values(activityArrayH),
														backgroundColor: rgba_x_number_array(Object.values(activityArrayH).length),
																borderColor: 'white',
																borderWidth: 1
													}]
												},
						options: {
									legend: {
										display: false
									},
									title: {
										display: true,
										text: '% of activity per hour'
									},
									scales: {
										yAxes: [{
										gridLines: {
											color: 'white',
											zeroLineColor: 'white'
										},
										ticks: {
											beginAtZero: true
										}
										}]
									}
								}
							});
						});

			</script>
            <canvas id="perc-per-day"></canvas>
		  
			<script>

				//Chart for actvity per day --> y=day, x=activity
				$.post('charts_data_filter_c.php',
										function(result){
											// console.log(result);
											var res3 = jQuery.parseJSON(result);
											var dayPercArray = [];
											var activityArrayD = [];
											for (var i = 0; i < Object.values(res3)[0].length; i++) {
												dayPercArray.push(Object.values(res3)[0][i]);
												activityArrayD.push(Object.values(res3)[1][i]);
											}										
					var ctx3 = document.getElementById('perc-per-day').getContext('2d');
					var chart_3 = new Chart(ctx3, {
						type: 'horizontalBar',
						data: {
							labels: Object.values(dayPercArray),
							datasets: [{
								data: Object.values(activityArrayD),
								backgroundColor: rgba_x_number_array(Object.values(activityArrayD).length),
										borderColor: 'white',
										borderWidth: 2
							}]
						},
						options: {
									legend: {
										display: false
									},
									title: {
										display: true,
										text: '% of actvity per day'
									},
									scales: {
										yAxes: [{
										gridLines: {
											color: 'white',
											zeroLineColor: 'white'
										},
										ticks: {
											beginAtZero: true
										}
										}]
									}
									}
								});
							});
			
			
			</script>
		
		</div>
         
        
      </div>
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
		  <textarea name="message" class="footer-contact" placeholder="Your message..."></textarea>
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