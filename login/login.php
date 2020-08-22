<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = mysql_real_escape_string($_POST['username']); //Για αντιμετωπιση mysql injection επιθεσεις καλύτερα απο απλο post
    $password = mysql_real_escape_string($_POST['password']);

    //Αν δεν έχει εισαγει καποιο username ή password error popup
    if(empty($username) && empty($passworrd))
    {
        $emptyerror = "Please insert username and password to login!";
        echo $emptyerror;
    }
    elseif(empty($username) && (!empty($passworrd)))
    {
        $emptyerror = "Please insert a username to login!";
        echo $emptyerror;
    }

    elseif((!empty($username)) && empty($passworrd))
    {
        $emptyerror = "Please insert a password to login!";
        echo $emptyerror;
    }

    else //Αν έχει καποιο username και password συμπληρωμένο
    {
        //mysql connection to database running by phpadmin for testing
        mysql_connect("localhost","root","");
        mysql_select("web_project");
        $sql1 = "SELECT * FROM user WHERE username = '$username' AND password = '$password' ";
        $result = mysql_query($sql1) or die("Failed to query database web_project".mysql_error());

        $rowRes = mysql_fetch_array($result);
        if($rowRes['username'] == $username && $rowRes['password'] == $password)
        {
            echo nl2br("Login successfull!\nConnected as: " $rowRes['role'] "\nWelcome " $rowRes['username']);
        }
        else
        {
            echo nl2br("Login Failed!\nWrong username or password!");
        }
    }
    
}
?>