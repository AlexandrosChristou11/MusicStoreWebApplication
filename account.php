<?php session_start();
if ($_SESSION['checkLogin'] != 2 && $_SESSION['checkLogin'] != 3 )
    header('location:accessDenied.php');
if ($_SESSION['checkLogin'] == 2){ $user = $_SESSION['username'];}
else  if ($_SESSION['checkLogin'] == 3){ $user = $_SESSION['s_username'];}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account</title>
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
            <a class="navbar-brand" href="home.php"><i id="fasAC" class='fas'>&#xf86d;</i></a>
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

<?php

    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $qUser = "SELECT * FROM login WHERE username='".$user."'";
    $rUser = mysqli_query($connection,$qUser);

    //$qP = "SELECT * FROM offers o, login l WHERE l.username = '".$user."' AND l.plan LIKE o.title";
    $qP = "SELECT plan FROM login WHERE username = '".$user."'";
    $rP = mysqli_query($connection,$qP);

    $qPlans = "SELECT * FROM offers";
    $rPlans = mysqli_query($connection, $qPlans);

?>



<h2 class="Cprofile">Profile</h2>

<div class="card3">
    <i style='font-size:74px' class='fas'>&#xf2c1;</i>
    <h1> <?php while ($rowU = mysqli_fetch_array($rUser,MYSQLI_ASSOC)){ echo $rowU['username'];} ?> </h1>
    <p class="title3">MEMBERSHIP</p>
    <p> <?php  if ($rowP = mysqli_fetch_array($rP, MYSQLI_ASSOC)) {

            $q = "SELECT * FROM offers WHERE  title = '".$rowP['plan']."'";
            $r = mysqli_query($connection,$q);
            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                echo "<img src=".$row['image']." alt='plan' style=\"width:80%\">";
            }
        } ?> </p>

    <!-- Change Plan    -->
    <div class="CChnagePlan">
        <p>Not satisfied? Change your plan NOW!</p>
    </div>

    <p>
        <form method="get" action="changePlan.php" name="changePlan">
    <p>
        <select name="changePlan">

            <?php
            while ($rowPlans = mysqli_fetch_array($rPlans, MYSQLI_ASSOC)){
                echo "<option value='".$rowPlans['title']."' >".$rowPlans['title']." - $".$rowPlans['price']."</option>";
            }
            ?>

        </select>
    </>
        <button type="submit" class="btn btn-danger" onclick="confirmChangePlan()">Change Plan</button>
    </form>
    </p>
</div>
<!--// REFERENCE
//W3schools.com. 2020. Tryit Editor V3.6. [online] Available at:
// <https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_product_card>
// [Accessed 11 April 2020].-->

<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>

</body>
</html>