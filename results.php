<?php session_start();
if (isset($_GET['search'])){
    $_SESSION['search'] = $_GET['search'];}
if ($_SESSION['checkLogin'] != 2 && $_SESSION['checkLogin'] != 3 )
    header('location:accessDenied.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Results</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
            <a class="navbar-brand" href="home.php"><i id="iFasRes" class='fas'>&#xf86d;</i></a><!--         Greeting to the user-->
            <?php if (isset($_SESSION["checkLogin"]))
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
</nav></div>
    </div>
</nav>
<!--    <h3 id="iRes">Results for <b> --><?php //echo $_SESSION['search'];?><!-- </b></h3>-->
<?php

    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $searchTracks = "SELECT * FROM tracks WHERE artist LIKE '".$_SESSION['search']."%' OR album LIKE '".$_SESSION['search']."%'
                     OR name LIKE '".$_SESSION['search']."%' OR genre LIKE '".$_SESSION['search']."%'";
    $rSearchTracks = mysqli_query($connection,$searchTracks);

    $searchPlans = "SELECT * FROM offers WHERE  title  LIKE '".$_SESSION['search']."%'";
    $rSearchPlans= mysqli_query($connection,$searchPlans);

    $checker = 0;

    // Check if any of the content exist
    if (  mysqli_num_rows($rSearchPlans) == 0 ){
        $checker++;
    }
    if (  mysqli_num_rows($rSearchTracks) == 0 ){
        $checker++;
    }

    // (1) NO results for this search
        if ($checker >=2 ){
            echo " <div id='iNoResult' class=\"alert alert-warning\">
                     <strong>Oops!</strong> Sorry, their are no results for this keyword. Wanna try an alternative keyword search?
                </div>";
            echo "    <div class=\"Csearch\">
        <form class=\"Cengine\" action=\"results.php\" method=\"get\">
            <label >Search again?</label><br>
            <input  placeholder=\"Search..\" type=\"text\" name=\"search\">
            <br>
    
            <button id=\"iBsearch2\" type=\"submit\" name=\"submit\" value=\"Search\" class=\"btn btn-default\">Search</button>
    <!--        <input id=\"iBsearch\" type=\"submit\" name=\"submit\" value=\"Search\" >-->
        </form>
        </div>";


    // (2) Found results for this search
    }else {
          echo "<h3 id='iRes'>Results for <b>". $_SESSION['search']." </b></h3>";
        // (a) Search in Tracks
        while ($r = mysqli_fetch_array($rSearchTracks, MYSQLI_ASSOC)) {
            echo "<h2 id='iFres'>" . $r['name'] . "</h2>

        <div class=\"card\">
          <img src=" . $r['thumb'] . " alt='SongsImg' id='iIMGRes'>
          <h1>" . $r['album'] . "</h1>
          <p class='price'>Description:</p>
          <p>" . $r['description'] . "</p>
          <p><button>" . $r['genre'] . "</button></p>
         <p><audio controls> <source src = " . $r['sample'] .
                " type='audio/mpeg'></audio></p>
        </div>";
        }

        // (b) Search in Offers
        while ($rp = mysqli_fetch_array($rSearchPlans, MYSQLI_ASSOC)) {
            echo "<h2 id='iOffersSearch'>" . $rp['title'] . "</h2>

        <div class=\"card\">
          <img src=" . $rp['image'] . " alt='SongsImg' id='iIMGRES1'>
          <h1> $" . $rp['price'] . "</h1>
          <p class='price'>Description:</p>
          <p>" . $rp['description'] . "</p>";
            echo "</div>";
        }

    } ?>

<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>

</body>
</html>