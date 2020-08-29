<?php require_once 'signup.php';?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Panoptikon</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    
<form class="box" action="index.php" method="post">
  <h1><img src="panoptikon.png" alt="logo" width="60" height="42"></h1>
  <h1 >Welcome to Panoptikon!</h1>
  
       
  <div class="btn-group">
    <button id="su_button" onclick="signup_select()">Sign Up</button>
    <button id="li_button" onclick="login_select()">Log In</button>
  </div>

  <script>
  function signup_select()
  {window.location.replace("http://localhost/test/index.php");
  
    if (x.style.display === "block" && y.style.display === "none") {
      x.style.display = "none";
      y.style.display = "block";
      l.style.background = "#191919";
      s.style.background = '#2ecc71';

    }
  }

  function login_select()
  {window.location.replace("http://localhost/test/index_li.php");
  
    if (y.style.display === "block" && x.style.display === "none") {
        y.style.display = "none";
        x.style.display = "block";
        l.style.background = '#2ecc71';
        s.style.background = '#191919';
    }
  }

  </script>



  <div id="signup">

    <input type="text" name=username id="username" class="form-control form-control-lg" placeholder="Username">
    <input type="text" name=firstname id="f_name" class="form-control form-control-lg" placeholder="Firstname">
    <input type="text" name=lastname id="l_name" class="form-control form-control-lg" placeholder="Lastname">
    <input type="email" name=email id="email" placeholder="E-mail" class="form-control form-control-lg">
    <input type="password" name=password id="password" placeholder="Password" class="form-control form-control-lg" required autocomplete="off">
    <input type="password" name=confirm_password id="passwconfirm" placeholder="Confirm Password" class="form-control form-control-lg" required autocomplete="off">
    <button type="submit" name="signup_btn" class="button button-block">Sign Up</button>

      </div> 
      </form>


  </body>
  

</html>
