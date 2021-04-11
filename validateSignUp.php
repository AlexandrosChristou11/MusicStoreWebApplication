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
            <a class="navbar-brand" href="home.php"><i id="iValSign" class='fas'>&#xf86d;</i></a><!--         Greeting to the user-->
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
<br>


<?php
    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $qlogin = "SELECT * FROM login";
    $result = mysqli_query($connection,$qlogin);
    $s_validator =0;

    $id =5;


    if (isset($_POST['s_username'])){
    $_SESSION['s_username'] =  $_POST['s_username'];
    $_SESSION['s_password'] = $_POST['s_password'];

    }
    if (isset($_POST['plan'])){
        $_SESSION['plan'] = $_POST['plan'];
    }

// ========== CHECKING IF USERNAME EXIST ======================
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        if ($_SESSION['s_username'] === $row['username']){
            $s_validator++;
        }
    }
    // (a) USERNAME EXIST
    if ($s_validator >= 1){
        echo "
           <div class=\"alert alert-danger\" id='iError'>
            <strong>Error!</strong>- Username already EXIST -
          </div>";
        echo "<a href='signUp.php'>  <div class=\"btn-group btn-group-lg\" class='iLogIn'>
                <button type=\"button\" class=\"btn btn-primary\">Return to Sign in Page</button></div></a>";
    }else
        //(b) USERNAME DOES NOT EXIST - SqlPrepared code (prevent sql injection)
        {

        $stmt = $connection->prepare ("INSERT INTO login(username,password,plan)VALUES (?,?,?)");
        $stmt->bind_param('sss',$addUsername,$addPassword,$addPlan);

        $addUsername = $_SESSION['s_username'];
        $addPassword = hash('SHA256',$_SESSION['s_password'].'cyprus');
        $addPlan = $_SESSION['plan'];
        $stmt->execute();
        $stmt->close();
        $connection->close();

        echo "You are connected <br>";
        $_SESSION['checkLogin'] = 3;
        echo $_SESSION['checkLogin'];
        header('location:home.php');

    }
//  REFERENCE :
// W3schools.com. 2020. PHP Mysql Prepared Statements. [online] Available at:
// <https://www.w3schools.com/php/php_mysql_prepared_statements.asp>
// [Accessed 11 April 2020].
    // ============================================================


?>


<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>


</body>
</html>
