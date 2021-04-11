<?php session_start();

$connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');

        // (1) Checking for user
        if ($_SESSION['checkLogin'] == 2){ $user = $_SESSION['username'];}
        else  if ($_SESSION['checkLogin'] == 3){ $user = $_SESSION['s_username'];}

        // (2) Takes the get parameter
        if (isset($_GET['changePlan'])){
            echo  $_SESSION['changePlan'] = $_GET['changePlan'];
        }
        $newPlan = $_SESSION['changePlan'];

        // (3) Update the Plan of the user
        $qUpdate =  "UPDATE login SET plan ='".$newPlan."' WHERE username='".$user."'";
        if (mysqli_query($connection,$qUpdate)){
            echo "change planned!!".$_SESSION['checkLogin'];
            header('location:account.php');
        }
