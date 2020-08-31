<?php
require_once 'send_email.php';
session_start();
//οταν παταει το signup
if (isset($_POST['signup_btn']))
{
//times metablhtwn apo site
$username = $_POST['username'];
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if(empty($username)) //la8os username
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
if(empty($email || !filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    $email_error = "Please insert a valid email!\n";
    echo $email_error; 
    $email_flag = 0;
    //tropod gis ns tsekarei to email einai epibebaiwsh mesw confirmation mhnyma pou 8a er8ei sto email
}
else
{
    $email_flag = 1;
}

//la8os password
if(empty($password) || strlen($password)<8 || !(preg_match('/[A-Z]/', $password)) || !(preg_match('/[a-z]/', $password)) || !(preg_match('/[0-9]/', $password)) || !(preg_match('/\W/', $password)))
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
if(!($password == $confirm_password)) //FIX name pairnei kai thn periptwsh poy den exei grapsei kwdiko epibebaiwshs
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
if ($usrmane_flag == 1 && $pass_flag == 1 && $email_flag == 1 && $pass_conf_flag == 1)
{
    $ok_flag = 1;
}
else
{
    $ok_flag = 0;
}

//AN OLA OK PROXWRAEI ME TO SIGNUP------------------------------------------------------
if($ok_flag == 1) 
{
    //syndesh me local database
    //mysql_connect("localhost","root","");
    //mysql_select("web_project");

    // Check connection
    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

        



    //check if email already exists
   $check_user_query = "SELECT * FROM user WHERE email = ? LIMIT 1";

    $stmt1 = $dbconnect->prepare($check_user_query);
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $res = $stmt1->get_result();
    $duplicate_count = $res->num_rows;


    if($duplicate_count >= 1)
    {
        echo "A user already exists with this E-mail!";
        $res->free_result();
        $dbconnect->close();//close connection with database
        exit();//maybe delete or keep?
    }
    else //register the user to database cause there is no duplicate
    {

        $cypherMethod='AES-256-CBC';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        $userID = openssl_encrypt($email, $cypherMethod, $password, 0, $iv);
        //$_SESSION['username'] = $username;
        $hashed_password=password_hash($password,PASSWORD_DEFAULT);
        $_SESSION['email'] = $email;
        $regDate =  date ('Y-m-d H:i:s', time());
        $role = "user";
        $verified_usr = "no";
        $token = bin2hex(random_bytes(50));//needed for veryfying user
        

        $sign_user_query = "INSERT INTO user(userID, username, fname, lname, password, iv, email, token, reg_date, role, verified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $dbconnect->prepare($sign_user_query);
        $stmt2->bind_param('sssssssssss', $userID, $username, $fname, $lname, $hashed_password, $iv, $_SESSION['email'], $token, $regDate, $role, $verified_usr);
        if($stmt2->execute())// mysqli_stmt_execute($stmt);
        {
            echo "Successful Registration to DataBase!" ."\n";
            $stmt2->close();
            sendVerificationEmail($email, $token); //ssl with xampp πρεπει να το φτιαξω αλλιως ερρορ "Enabling SSL with XAMPP".

        }
        else
        {
            echo "Registration to DataBase Failed!";
            $stmt2->close(); 
        }

        exit();

    }//end register the user to database


}
}

?>