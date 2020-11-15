<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<title>PANOPTIKON</title>
	<link rel="stylesheet" href="admin_style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body onload="start()">
	<div class="pill-nav">
		<button class="tablinks" onclick="changeTab('home_tab')">Home</button>
		<button class="tablinks" onclick="changeTab('data_filter_tab')">Data Filter</button>
		<button class="tablinks active" onclick="changeTab('dash_tab')">Dashboard</button>
		<button class="tablinks" onclick="changeTab('profile_tab')">Profile</button>
		<button class="tablinks" onclick="changeTab('about_tab')">About</button>
		

	  </div>


<section>
  
  <aside>
    <ul id="tabs" role="toolbar">
      <div id="user">
        <h1><img src="panoptikon.png" alt="logo" width="50" height="35">Panoptikon</h1> 
        <h3 id="name"> <strong>Welcome</strong> </h3> <?php// echo $user_info[5] .", " . $user_info[0];?> 
        <form  action = "" method="post">
      <button name="log_out" id="logout" >Log Out</button>
      </form>
			  <hr>
			  <!--<p>Ecological Score:</p>
			  <p>Sign up Period Coverage:</p>
			  <p>File last uploaded at:</p>-->
			  <button id="delete">Delete All Data </button>
			  
    </ul>
</aside>

  
<article>

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
<script src="admin_function.js"></script>
</body>
</html>
