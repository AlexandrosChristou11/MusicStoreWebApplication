<?php session_start();

    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $track = $_SESSION['trackId'];
    if ($_SESSION['checkLogin'] == 2 ){$user = $_SESSION['username'];}
    else if  ($_SESSION['checkLogin'] == 3) { $user = $_SESSION['s_username']; }

    echo $track." ".$user;


    if (isset($_GET['trackId'])){
        $_SESSION['trackId'] = $_GET['trackId'];
    }
    if (isset($_GET['genre'])){
        $_SESSION['genre'] = $_GET['genre'];
    }

    $addTrack = "INSERT INTO playlist(track_id,user) VALUES ($track,'$user')";
    $rAddTrack = mysqli_query($connection,$addTrack);
    echo $rAddTrack;
header('location:tDescription.php?trackId='.$_SESSION['trackId']."&album=".$_SESSION['album']."&genre=".$_SESSION['genre']);