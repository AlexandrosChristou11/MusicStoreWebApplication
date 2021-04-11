<?php session_start();
if (!isset($_SESSION['checkLogin'])) {$_SESSION['checkLogin'] = 1;}

if ($_SESSION['checkLogin'] != 2 && $_SESSION['checkLogin'] != 3 )
    header('location:accessDenied.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Track</title>
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
            <a class="navbar-brand" href="home.php"><i id="iFasDesc" class='fas'>&#xf86d;</i></a><!--         Greeting to the user-->
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
                <<li> <form class="CengineTop" action="results.php" method="get">
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
    $qTra = "SELECT * FROM tracks WHERE track_id=".$_GET['trackId'];

    // (a) GET track_id from table tracks
    $rTra = mysqli_query($connection,$qTra);
    if (isset($_GET['trackId'])){
        $_SESSION['trackId'] = $_GET['trackId'];
    }

    $qRev = "SELECT * FROM reviews WHERE product_id=".$_GET['trackId'];
    $rRev = mysqli_query($connection,$qRev);

    // (b) GET album of track
    if (isset($_GET['album'])){
        $_SESSION['album'] = $_GET['album'];
    }
    if (isset($_GET['genre'])){
        $_SESSION['genre'] = $_GET['genre'];
    }

    //(c) Check User
    if ($_SESSION['checkLogin'] == 2) { $admin = $_SESSION['username']; }
    else if ($_SESSION['checkLogin'] == 3) { $admin = $_SESSION['s_username']; }

    // Same album query
    $qAlb = "SELECT * FROM tracks WHERE album ='".$_SESSION['album']."'";
    $rAlb = mysqli_query($connection,$qAlb);

    // === TRACKS DESCRIPTION =======================================
    while ($rowTra = mysqli_fetch_array($rTra,MYSQLI_ASSOC)) {
        echo "
        <h2 class='CgenreDesc'>" . $rowTra['name'] . "</h2>

        <div class=\"card\">
          <img src=" . $rowTra['thumb'] . " alt='SongsImg'id='iIMGDesc'>
          <h1>" . $rowTra['album'] . "</h1>
          <p class='price'>Description:</p>
          <p>" . $rowTra['description'] . "</p>
          <p><button>" . $rowTra['genre'] . "</button></p>
         <p><audio controls> <source src = " . $rowTra['sample'] .
            " type='audio/mpeg'></audio></p>";

//        if (mysqli_num_rows($rCheck) == 0) {
            echo "<p><form name='fAddPlaylist' action='addTrackPlaylist.php' method='post'>
                 <input type='submit' value='Add to Playlist' <button type=\"button\"  class=\"btn\"></button> <br>
                </form></p>";
//        }
//        else echo "HELLO !!";
        echo "</div>";
    }
// REFERENCE
//W3schools.com. 2020. Tryit Editor V3.6. [online] Available at:
// <https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_product_card>
// [Accessed 11 April 2020].




    // ======= REVIEWS ==================================
        echo "<h2 id='iRev'>Reviews</h2><br>";
    while ($rowRev = mysqli_fetch_array($rRev,MYSQLI_ASSOC)){
        echo "
        <div class='card'>
         <h3 id='iName'><i id='iFasDescri' class='fas'>&#xf2bd;".$rowRev['name']."  </i></h3>
        <p>'' ".$rowRev['review']." ''</p>
        <p>Rating: <b>".$rowRev['rating']."</b></p>
       </div>
        ";
    }
    echo "<br>";
    echo "<br>";
        // ==== AVERAGE RATING ==
        //(a) Number of rates
        $qCount = "SELECT COUNT(*) AS total FROM reviews WHERE product_id=".$_SESSION['trackId'];
        $rCount = mysqli_query($connection,$qCount);
        if ($rCount){
            while ($rowCount = mysqli_fetch_assoc($rCount)){
                echo "<h5 class='CnumRat'><i class='fas'>&#xf1ec;</i> Number of Ratings :".$rowCount['total']."</h5><br>";
                if ($rowCount['total'] == 0) { echo "<h5 class='CnumRat'><i id='iFasRates2' class='fas'>&#xf005;</i>Average Rating: 0 </h5>";}else{
                    //(b) Average rate
                    $qAve = "SELECT AVG(rating) AS average FROM reviews  WHERE product_id=".$_SESSION['trackId'];
                    $rAve = mysqli_query($connection,$qAve);
                    while ($rowAve = mysqli_fetch_array($rAve,MYSQLI_ASSOC)){
                        echo "<h5 class='CnumRat'><i id='iFasAverage' class='fas'>&#xf005;</i>Average Rating: ".$rowAve['average']."</h5>";
                    }

                }
            }
        }

    echo "<br>";
    echo "<br>";

    // ===== Ask user to rate ===
      if (isset($_GET['genre'])){
            $_SESSION['genre'] = $_GET['genre'];
        }
        echo
        "<form name='fRating'  method='post' action='addRating.php' onsubmit='message()'>
            <div class='form-group'>
            <h4 class='Crate'> How about a rating? </h4>
            <textarea placeholder='Write a review...' class='form-control' rows='5' id='comment' name='review'  required></textarea><br>
           <div class='Crating'>
           <label for='quantity'>Rating (1-10) </label> <br>
           
           <input class='form-control' id='iNum' type='number' name='rate' min=\"1\" max=\"10\" required >
         <br> <button id='iRate' type='submit' name='submit' class=\"btn btn-default\">Rate</button>
          
         
         </div>
        </div>
      </form>";

    //====================================================================

//========== Tracks in the same album============
        echo" <button class='accordion'>Tracks in the same album</button>
        <div class='panel'>";
        //<p> </p>";
        echo "<table class='CtableAlbum'>"."<tr><th> Name </th> <th> Artist </th> <th> More..</th></tr>";

        while ($rAl = mysqli_fetch_array($rAlb,MYSQLI_ASSOC)){
            echo "<tr>"."<td>".$rAl['name']."</td><td>".$rAl['artist']."</td>"."<td>".
                 "<a  href = 'tDescription.php?trackId=".$rAl['track_id']."&album=".$rAl['album']."'"."> More..
                 </a></td></tr>";



        }
echo "</table>";
echo   "</div>";

?>

<script>
    function message() {
        alert ("Review succesfully added !!");

    }

    let acc = document.getElementsByClassName("accordion");
    let i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            let panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }

</script>


<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>

</body>
</html>

