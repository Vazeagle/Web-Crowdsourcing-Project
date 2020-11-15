<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

if (isset($_POST["erase_all_user_data"]))//ΑΝ πατηθει το κουμπι Erase All Users Locations
{
    // Check connection
    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

    //get data from database querries
    $admin_del_loc_query= "DELETE * FROM map_data";

    $stmt_admin_del_loc = $dbconnect->prepare($admin_del_loc_query);
    if($stmt_admin_del_loc->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
        $notification = "Successful Deletion of all users location data!";
        echo $notification;
        $stmt_admin_del_loc->close();
    }
    else
    {
        $notification = "Error Deleting users locations!";
        echo $notification;
        $stmt_admin_del_loc->close();
    }
}


if (isset($_POST["erase_all"]))//ΑΝ πατηθει το κουμπι Erase All Data From Data Base
{
    // Check connection
    $dbconnect = new mysqli("localhost","root","","web_project") or die("Couldn't connect to Database web_project") ;

    //get data from database querries
    $admin_delete_user_and_data_query= "DELETE * FROM user WHERE role='user' ";

    $stmt_admin_del_all = $dbconnect->prepare($admin_delete_user_and_data_query);
    if($stmt_admin_del_all->execute())//Αν εκτελεστει και ολα οκ προχωρα
    {
        $notification = "Successful Deletion of all users and their data";
        echo $notification;
        $stmt_admin_del_all->close();
    }
    else
    {
        $notification = "Error Deleting users and their data!";
        echo $notification;
        $stmt_admin_del_all->close();
    }
}


?>