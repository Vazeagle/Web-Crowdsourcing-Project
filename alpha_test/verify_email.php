<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Panoptikon</title>
    <link rel="stylesheet" href="http://localhost/test/user_verify/logver_style.css">
  </head>
  <body>
    
<form class="box" action="verify_email.php" method="post">
  <h1><img src="panoptikon.png" alt="logo" width="60" height="42"></h1>
  <h1 >Welcome to Panoptikon!</h1>

  <?php

        session_start();
        if (isset($_GET['token'])) {

            //συνδεση με ΒΔ
            $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

            //GET ΤΟ ΜΟΝΑΔΙΚΟ TOKEN ΓΙΑ VERIFICATION
            $token = $_GET['token'];
            $sql_q = "SELECT username,email FROM user WHERE token = ? LIMIT 1";   //ΑΝΑΖΗΤΗΣΗ ΓΙΑ ΤΟ ΤΟΚΕΝ

            $stmt_v = $dbconnect->prepare($sql_q);
            $stmt_v->bind_param('s', $token);
            if($stmt_v->execute())
            {
                $result = $stmt_v->get_result();
                $user_info = $result->fetch_array(MYSQLI_NUM);//user_info
                $rownum = $result->num_rows;
                $result->free_result();
                $stmt_v->close();
            }

            if ($rownum > 0)
            {

                $verify_q = "UPDATE user SET verified_user='yes' WHERE token=?";//ΚΑΝΕ UPDATE TO ΤΟΚΕΝ ΣΕ yes δλδ verifiyed user!
                $stmt_v2 = $dbconnect->prepare($verify_q);
                $stmt_v2->bind_param('s', $token);
                if($stmt_v2->execute())
                {
                    $message = "Your email address '" . $user_info[1] . "' has been verified successfully!"; 
                    $stmt_v2->close();
                }
                else
                {
                    $message = "Your email address " . $user_info[1] . " failed to be verifyied!";                   
                    $dbconnect->close();
                }

            }
            else 
            {
              $message = "User not found! Please try again!";
                $dbconnect->close();
            }
        }
        else
        {
          $message = "No token provided! Please try again!";
        }
?>

      <div id="postSU">
      <?php $notify = $user_info[0] . ", " . $message;?>

        <h3> <?php echo  $notify;?> </h3>
      <p>Please press the redirect link to login page. </p>
      <button type="submit" name = "redirect_login" class="button button-block">Redirect to Login!</button>
      
        </div>
        <?php 
          if (isset($_POST['redirect_login']))
          {
            header("location: http://localhost/test/index_li.php");
          }
        ?>

</form>


  </body>
</html>