<?php session_start();

    if (isset($_GET['trackId']))
     $_SESSION['trackId'] = $_GET['trackId'];

    if ($_SESSION['checkLogin'] == 2){
        $user =  $_SESSION['username'];
    }else{
        $user = $_SESSION['s_username'];
    }

    $connection = mysqli_connect('localhost', 'achristou4', 'HznB6091', 'achristou4');
    $qRemoveTrack = "DELETE FROM playlist WHERE track_id = ".$_SESSION['trackId']." AND user LIKE '".$user."'";
    $rRemoveTrack = mysqli_query($connection,$qRemoveTrack);
    header('location:playlist.php');