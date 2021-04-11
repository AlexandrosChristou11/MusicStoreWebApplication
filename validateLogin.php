<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Validating ..</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php"><i id="iFasValogin" class='fas'>&#xf86d;</i></a><!--         Greeting to the user-->
            <?php
                if ($_SESSION["checkLogin"] == 2){
                    echo " <p class='CgreetingUser'>👋 ".$_SESSION['username'];
                }else if ($_SESSION['checkLogin'] == 3) {
                    echo " <p class='CgreetingUser'>👋 ".$_SESSION['s_username'];
                } ?>
            <!--------------------------------------->
        </div>


        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="home.php">Home</a></li>
                <li><a href="playlist.php">Playlist</a></li>
                <li><a href="tracks.php">Tracks</a></li>
                <li><a href="account.php">Account</a></li>
                <li> <form class="CengineTop" action="results.php" method="get">
                        <input  placeholder="Search.." type="text" name="search">
                        <br>
                        <button id="iBsearch1" type="submit" name="submit" value="Search" class="btn btn-default">Search</button>
                    </form></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($_SESSION['checkLogin'] == 1){echo" <li><a href='loginForm.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";}
                else{
                    echo " <li><a href='changeStatus.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";}
                ?>
            </ul>
        </div>
    </div>
</nav>
<br>



<?php

    // Queries
    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $qlogin = "SELECT * FROM login";
    $result = mysqli_query($connection,$qlogin);
    $validator =0;

    if (isset($_POST['username'])){
        $_SESSION['username'] =  $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
       // $_SESSION['checkLogin'] = $_POST['checkLogin'];
    }

    // (1) Correct credentials - Go to home page
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {

        if ($_SESSION['username'] === $row['username'] && hash('SHA256',$_SESSION['password'].'cyprus')  === $row['password']){
            $validator++;
        }
    }
    if ($validator >= 1){
        echo "You are logged in!! <br>";
        $_SESSION['checkLogin'] = 2;
        echo "after log in :". $_SESSION['checkLogin'];
        echo password_hash($_SESSION['password'],PASSWORD_BCRYPT);
        header('location:home.php');

    }else
        // (2) Wrong Credetials - Return to login
        {
        echo "
           <div class=\"alert alert-danger\" id='iError'>
            <strong>Error!</strong> Incorrect Input Details !!
          </div>";
        echo "<a href='loginForm.php'>  <div class=\"btn-group btn-group-lg\" class='iLogIn'>
                <button type=\"button\" class=\"btn btn-primary\">Return to Log in Page</button></div></a>";

    }
?>


<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>
</body>
</html>
