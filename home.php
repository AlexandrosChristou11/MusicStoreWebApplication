<?php session_start();
if (!isset($_SESSION['checkLogin']))
    $_SESSION['checkLogin'] = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MusicAl</title>
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
            <a class="navbar-brand" href="home.php"><i id="iFasHome" class='fas'>&#xf86d;</i></a>
            <!--         Greeting to the user-->
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
                <li class="active"><a href="#">Home</a></li>
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



<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="audience-1867754_1920.jpg" alt="ImageLanding">
            <div class="carousel-caption">
                <h3>Sell $</h3>
                <p>Money Money.</p>
            </div>
        </div>

        <div class="item">
            <img src="black-and-white-2564630_1920.jpg" alt="Image">
            <div class="carousel-caption">
                <h3>More Sell $</h3>
                <p>Lorem ipsum...</p>
            </div>
        </div>
    </div>
    <!-- Reference   -->
    <!--  W3schools.com. 2020. Bootstrap Theme "The Band". [online]
    Available at: <https://www.w3schools.com/bootstrap/bootstrap_theme_band.asp>
    [Accessed 11 April 2020].  -->


<!--     Left and right controls-->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

    <!-- SEARCH ENGINE  -->
    <div class="Csearch">
    <form class="Cengine" action="results.php" method="get">
        <label >Don't find something?</label><br>
        <input  placeholder="Search.." type="text" name="search">
        <br>

        <button id="iBsearch" type="submit" name="submit" value="Search" class="btn btn-default">Search</button>
<!--        <input id="iBsearch" type="submit" name="submit" value="Search" >-->
    </form>
    </div>
    <?php

    if (isset($_GET['search'])){
       $_SESSION['search'] = $_GET['search'];
    }


    ?>


    <!--- PLANS ---->
    <?php



    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $qReviews = 'SELECT * FROM offers';
    $rReviews = mysqli_query($connection,$qReviews);

    // === RETRIEVE PLANS FROM DATABASE ====
    echo "<h2 id = 'iReview'><u> ★ PLANS ★</u> </h2>";
    while ($rowOf = mysqli_fetch_array($rReviews,MYSQLI_ASSOC)){

        echo"
        <h2 class='CplansHome'>".$rowOf['title']."</h2>

        <div class=\"card\">
          <img src=".$rowOf['image']." alt='SongsImg' id='iIMGHome'>
         
          <p class='price'>Description:</p>
          <p>".$rowOf['description']."</p>
          <p><button>$".$rowOf['price']."</button></p>
         
        </div>";
        echo "<hr>";
    }
    ?>
<!--//    REFERENCE-->
<!--//    W3schools.com. 2020. Tryit Editor V3.6. [online] Available at:-->
<!--    // <https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_pricing_table>-->
<!--    // [Accessed 11 April 2020].-->






<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>

</div>
</body>
</html>


