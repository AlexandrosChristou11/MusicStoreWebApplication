<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SignUp</title>
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
            <a class="navbar-brand" href="home.php"><i id="iFasSign" class='fas'>&#xf86d;</i></a><!--         Greeting to the user-->
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
                        <button id="iBsearch1" type="submit" name="submit" value="Search" class="btn btn-default">Search</button>
                </form></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($_SESSION['checkLogin'] == 1){echo" <li><a href='loginForm.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";}
                else{
                    echo " <li><a href='changeStatus.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";}?>
            </ul>
        </div>
    </div>
</nav>


<!--// ====== SIGN-UP FORM ======================-->
<h2 id="iLog">SignUp Form</h2>
<form name="fSignUp" method="post" action="validateSignUp.php" onsubmit="return checkPassword()">


    <div class="Fcontainer">
        <label>Username</label>
        <input type="text" placeholder="Enter Username" name = "s_username" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name = "s_password" required>


        <label>Select Plan</label><br>
        <select name = "plan">
            <?php
            $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
            $qOffers= "SELECT * FROM offers";
            $rOffers = mysqli_query($connection,$qOffers);
            $validator =0;
            while ($rowOffer = mysqli_fetch_array($rOffers,MYSQLI_ASSOC)){
            echo"

            <option name = '".$rowOffer['title']."' value='".$rowOffer['title']."'>".$rowOffer['title']." - $ ".$rowOffer['price']."</option>
            ";

            }?>
        </select>
        <button class="fButton" id ='iButton' type="submit">Sign Up</button>
        <p id="iTerms">By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <a href="loginForm.php">Already got an account? Login NOW</a>
    </div>


</form>



<script>
    function checkPassword() {
        let vPassword = document.forms['fSignUp']['s_password'].value;
        if (vPassword.length < 8){
            alert("To small password! Password should be at least 8 characters.");
            return false;
        }else{ return true;}

    }

</script>

<?php
    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    ?>


<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>
</body>
</html>
