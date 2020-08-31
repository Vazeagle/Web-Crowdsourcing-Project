<?php //require_once 'login.php';
require_once(__DIR__.'\login.php')
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Panoptikon</title>
    <link rel="stylesheet" href="style.css">
    
  </head>
  <body>
    
<form class="box" action="index_li.php" method="post">
  <h1><img src="panoptikon.png" alt="logo" width="60" height="42"></h1>
  <h1 >Welcome to Panoptikon!</h1>
  <?php
   echo $_SESSION['msg'];
   ?>
       
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


      <div id="login">


        <input type="text" name = "e-mail" id="email" placeholder="E-mail">
        <input type="password" name = "password_li" id="password" placeholder="Password" required autocomplete="off">
        <p><a type="forgot" href="">Forgot your password? </a></p>
        <button type="submit" name=login_btn class="button button-block">Login</button>
  
    </div>

      </form>


  </body>
</html>