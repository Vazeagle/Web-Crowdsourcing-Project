<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
	<title>PANOPTIKON</title>
	<link rel="stylesheet" href="admin_style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body onload="start()">
	<div class="pill-nav">
		<button id="hometab" class="tablinks" onclick="openTab(event, 'home')">Home</button>
		<button class="tablinks" onclick="openTab(event, 'searchtab')">Search</button>
		<button class="tablinks" onclick="openTab(event, 'home')">Dashboard</button>
		<button class="tablinks" onclick="openTab(event, 'home')">Profile</button>
		<button class="tablinks" onclick="openTab(event, 'home')">About</button>
		<button class="tablinks" onclick="openTab(event, 'home')">Log Out</button>
	  </div>

<section>
  
  <aside>
    <ul id="tabs" role="toolbar">
		<div id="user">
			<h1><img src="panoptikon.png" alt="logo" width="50" height="35">Panoptikon</h1> 
			<h3 id="name"> <strong>Username</strong> </h3>
			  <hr>
			  <!--<p>Ecological Score:</p>
			  <p>Sign up Period Coverage:</p>
			  <p>File last uploaded at:</p>-->
			  <button id="delete">Delete All Data </button>
			  
    </ul>
</aside>

  
  <article>
	<div class="row">
		<div class="column">
			<h2>This is the users' total activity.</h2>
			<div  id='map'> </div>

			<div id="searchload">
				<div id="searchbar">10%</div>
			</div>
			  
			<button id="extract">Extract Data </button>
			
			<script src="admin_function.js"> </script>

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
				
				<script src="admin_function.js"> </script>

			</div>
	<script src="admin_function.js"> </script>
  </article>

    
</section>



<footer>
	<h1><img src="panoptikon.png" alt="logo" width="70" height="49">Panoptikon</h1>
	<p>Panoptikon is a crowdsourcing website, centered around the city of Patras and Rion.</p>
	<p>Developed for a project in the Computer Engineering and Informatics Department in the University of Patras.</p>
	<div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
	<div class="btn-group">
		<button>Home</button>
		<button>Search</button>
		<button >Profile</button>
		<button >About</button>
		<button >Log Out</button>
	  </div>
	
</footer>

</body>
</html>
