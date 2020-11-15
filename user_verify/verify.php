<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Panoptikon</title>
    <link rel="stylesheet" href="logver_style.css">
  </head>
  <body onload="start()" >
    
<form class="box" action="verify.php" method="post">
  <h1><img src="panoptikon.png" alt="logo" width="60" height="42"></h1>
  <h1 >Welcome to Panoptikon!</h1>
  
  <?php
      require_once(__DIR__.'\..\send_email.php');
      session_start();
      // Check connection
    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

    //get data from database querries
    $user_info= "SELECT username, email, token FROM user WHERE userID = ?";

    $stmt_usr = $dbconnect->prepare($user_info);
    $stmt_usr->bind_param('s', $_SESSION['userID']);
    if($stmt_usr->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
      $result = $stmt_usr->get_result();
      $usr_info = $result->fetch_array(MYSQLI_NUM);//user_info
      $result->free_result();
      $stmt_usr->close();
      $dbconnect->close();
    }
    else
    {
      $notification = "Error getting user info!";
      $dbconnect->close();
      echo $notification;
    }
  ?>
      <div id="postSU">


        <h3>You are not currently logged in, <?php echo $usr_info[0];?></h3>
      <p>You need to verify your account. Please sign in to your e-mail account '<strong> <?php echo $usr_info[1];?> </strong>' and press the verification link. </p>
      <button type="submit" name="resend_btn" class="button button-block">Resend verification!</button>
      <?php
       if (isset($_POST['resend_btn']))
       {
         sendVerificationEmail( $usr_info[1],  $usr_info[2]);
        }
       ?>
        </div>
        

</form>


  </body>
</html>
