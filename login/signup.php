<?php
session_start();
//οταν παταει το signup

//times metablhtwn apo site
$username = $_POST['username'];
$email = $_POST['email'];
$passworrd = $_POST['password'];
$confirm_passowrd = $_POST['confirm_password'];

if(empty($username) //la8os username
    {
        $username_error = "Please insert a valid username!\n";
        echo $username_error;
        $usrmane_flag = 0;
    }
else
{
    $usrmane_flag = 1;
}

//la8os email
if(empty($email || !filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $email_error = "Please write a valid email!\n";
    echo $email_error;
    $email_flag = 0;
    //tropod gis ns tsekarei to email einai epibebaiwsh mesw confirmation mhnyma pou 8a er8ei sto email
}
else
{
    $email_flag = 1;
}

//la8os password
if(empty(empty($passworrd) || strlen($passworrd)<8 || preg_match('/[A-Z]/', $passworrd) || preg_match('/[0-9]/', $passworrd) || preg_match('/\W/', $passworrd))
{
    $password_error = "Please insert a valid password! At least 8 characters,  one upper-case character(A-Z), a number(0-9) and a sumbol such as @, #, $\n";
    echo $password_error;
    $pass_flag = 0;
}
else
{
    $pass_flag = 1;
}



//la8os confirmation password
if(!($passworrd == $confirm_passowrd)) //FIX name pairnei kai thn periptwsh poy den exei grapsei kwdiko epibebaiwshs
{
    $conf_pass_error = "The passwords don't match up! Please check them again!\n";
    echo $conf_pass_error;
    $pass_conf_flag = 0;
}
else
{
    $pass_conf_flag = 1;
}

//An ola ok katallhlo flag gia na prwxvrhsoyme
if ($usrmane_flag == 1 && $pass_flag = 1 && $email_flag = 1 && $pass_conf_flag = 1)
{
    $ok_flag = 1;
}
else
{
    $ok_flag = 0;
}

//AN OLA OK PROXWRAEI ME TO SIGNUP------------------------------------------------------
if(ok_flag == 1) 
{
    //syndesh me local database
    //mysql_connect("localhost","root","");
    //mysql_select("web_project");

    // Check connection
    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

    //check if email already exists
    $check_user_query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $email_check = mysqli_query($dbconnect, $check_user_query);
    //or with stmt
    //$stmt1 = $dbconnect->prepare($check_user_query);
    //stmt1->bind_param('s', $email);
    //stmt1->execute();
    //$res = $stmt1->get_result();
    //duplicate_count = $res->num_rows;

    if(mysqli_num_rows(email_check) == 1) //if(duplicate_count == 1)
    {
        echo "A user already exists with this E-mail!"
        $dbconnect -> close();//close connection with database
        //exit();//maybe delete or keep?
    }
    else //register the user to database cause there is no duplicate
    {
        $cypherMethod='AES-256-CBC';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

        $_SESSION['userID'] = openssl_encrypt($email, $cypherMethod, $password, 0, $iv);
        $_SESSION['username'] = $username;
        $_SESSION['password'] = password_hash($password,PASSWORD_DEFAULT);
        $_SESSION['iv'] = $iv;
        $_SESSION['email'] = $email;
        $_SESSION['reg_date'] =  date ('Y-m-d H:i:s', $phptime);
        $_SESSION['role'] = "user";
        $_SESSION['verified_user'] = "no";

        $sign_user_query = "INSERT INTO user(userID, username, password, iv, email, reg_date, role, verified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $dbconnect->prepare($sign_user_query);
        $stmt2->bind_param('sssssss', $_SESSION['userID'], $_SESSION['username'], $_SESSION['password'],  $_SESSION['iv'], $_SESSION['email'], $_SESSION['reg_date'], $_SESSION['role'], $_SESSION['verified_user'])
        if($stmt2->execute())// mysqli_stmt_execute($stmt);
        {
            echo "Successful Registration to DataBase!"
            $stmt2->close(); 
        }
        else
        {
            echo "Registration to DataBase Failed!"
            $stmt2->close(); 
        }

        exit();

    }//end register the user to database


}

?>