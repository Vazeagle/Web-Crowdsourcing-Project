<?php
session_start();
//οταν παταει το signup
if (isset($_POST['login_btn']))
    {

    //$email_li = mysql_real_escape_string($_POST['e-mail']); //Για αντιμετωπιση mysql injection επιθεσεις καλύτερα απο απλο post
    //$password_li = mysql_real_escape_string($_POST['password_li']);
    $email_li = $_POST['e-mail']; //Για αντιμετωπιση mysql injection επιθεσεις καλύτερα απο απλο post
    $password_li = $_POST['password_li'];

    //la8os email
    if(empty($email_li || !filter_var($email_li, FILTER_VALIDATE_EMAIL)))
    {
        $email_error_li = "Please insert a valid email!\n";
        echo $email_error_li; 
        $email_flag_li = 0;
    }
    else
    {
        $email_flag_li = 1;
    }


    //la8os password
    if(empty($password_li))
    {
        $password_error_li = "Please insert a password!";
        echo $password_error_li;
        $pass_flag_li = 0;
    }
    else
    {
        $pass_flag_li = 1;
    }

    //An ola ok katallhlo flag gia na prwxvrhsoyme
    if ($email_flag_li == 1 && $pass_flag_li == 1)
    {
        $ok_flag_li = 1;
    }
    else
    {
        $ok_flag_li = 0;
    }

    if($ok_flag_li ==1) //AN ola kala sunexise me login
    {
        // Check connection
        $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

        //login check
        $login_query = "SELECT userID, password ,role FROM user WHERE email = ?";
        //$login_query = "SELECT userID,username,role,verified_user FROM user WHERE email = ? AND password = ?";

        
        $stmt = $dbconnect->prepare($login_query);
        $stmt->bind_param('s', $email_li);
        $stmt->execute();
        $res = $stmt->get_result();
        $rownum = $res->num_rows;


        if($rownum == 1)//an ena akribws match δλδ υπαρχει το email
        {
            $datar = $res->fetch_array(MYSQLI_NUM);
            $res->free_result();
            $stmt->close();
            $pass_check=$datar[1];
            $h_pass=password_verify($password_li,$pass_check);

            if ($h_pass)//αν ειναι σωστος ο κωδικος
            {
                $_SESSION['userID']=$datar[0];
                $_SESSION['role']=$datar[2];
                $res->free_result();
    
                //$_SESSION['verified_user']=$datar[3];
                //if(verified_user=="yes")
                //{header("location: welcome.php");
                //else{echo "Please verify your account";}
    
                //insert se logs}
                $dt = date ('Y-m-d H:i:s', time());
                $insert_logs_query = "INSERT INTO logs(userID, logDate) VALUES (?, ?)";
                $stmt3 = $dbconnect->prepare($insert_logs_query);
                $stmt3->bind_param('ss',$_SESSION['userID'], $dt);
                header("location: welcome.php");//ΑΛΛΑΓΗ ΣΕΛΙΔΑΣ ΣΕ WELCOME USER
                
                if($stmt3->execute())   //AN ΓΙΝΕΙ ΣΩΣΤΑ ΤΟ INSERTION SYNDESOU
                {
                    echo "Successful insertion to DataBase!" ."\n";
                    echo $password;
                    $stmt3->close(); 

                    header("location: welcome.php");    //ΑΛΛΑΓΗ ΣΕΛΙΔΑΣ ΣΕ WELCOME USER
        
                }
                else
                {
                    $dbconnect->close();
                    echo "Insertion to DataBase Failed!";
                    $stmt3->close();
                }
            }
            else
            {
                $dbconnect->close();
                $login_error="Invalid password!";
                echo $login_error;
            }
           


        }
        else
        {
            $dbconnect->close();
            $login_error="Invalid user e-mail!";
            echo $login_error;
        }
    }

}
?>
