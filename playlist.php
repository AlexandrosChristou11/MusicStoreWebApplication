<?php session_start();
if ($_SESSION['checkLogin'] != 2 && $_SESSION['checkLogin'] != 3 )
    header('location:accessDenied.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Playlist</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
            <a class="navbar-brand" href="home.php"><i id="iFasPl" class='fas'>&#xf86d;</i></a><!--         Greeting to the user-->
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
        <h1 id="iTracks"> PLAYLIST </h1>
        <br>
    <form name="fPlaylist" action="playlist.php" method="get">
        <hr class="CGenerate">
        <h4 id="iGentext">Generate a random playlist</h4>
        <button type="submit" id="iGenerate" name="generate" value="Generate"  class="btn btn-success">Generate</button>
        <hr class="CGenerate" id="iGenerateLine">
    </form>


<?php
        $connection = mysqli_connect('localhost', 'achristou4', 'HznB6091', 'achristou4');

        // Validates user
        if ($_SESSION['checkLogin'] == 2){
            $user = $_SESSION['username'];
        }else if ($_SESSION['checkLogin'] == 3){
            $user = $_SESSION['s_username'];
        }
                // == (a) UI Generate Random Playlist

                if (isset($_GET['generate'])){
                    $_SESSION['generate'] = $_GET['generate'];
                }
                $qPlaylist = "SELECT * FROM tracks ORDER BY RAND() LIMIT 5";
                $rPlaylist = mysqli_query($connection, $qPlaylist);
                echo "<br>";
                echo "<br>";
                $number = 1;
                echo "<table class='iTgen'>";
                echo "<tr>" . "<th> Artist </th>" .
                    "<th> Name </th>" . "<th> Audio </th>" . "<th> Descr. </th>" . "</tr>";

                while ($playlist = mysqli_fetch_array($rPlaylist, MYSQLI_ASSOC)) {
                    if ($number < 2) {
                        echo "<h3 class='iRec'><i id='iFasPlT' class='fas'>&#xf590;</i>
                                         Random Playlist </h3><br>";
                    }
                    $number++;
                    echo

                        "<td>" . $playlist['artist'] .
                        "</td>" . "<td>" .
                        $playlist['name'] . "</td> <td>" .
                        "<audio controls> <source src = " . $playlist['sample'] .
                        " type='audio/mpeg'></audio></i> </td>" . "<td>" .
                        "<a  href = 'tDescription.php?trackId=" . $playlist['track_id'] . "&album=" . $playlist['album'] . "&genre=" . $playlist['genre'] . "'" . "> More..
                                                </a></td></tr>";
                }
                echo "</table>";
            // ===================================================================

            // (b) Users own Playlist
            $qList = "SELECT DISTINCT * from tracks t,playlist p WHERE p.track_id = t.track_id AND p.user='".$user."'";
            $rList = mysqli_query($connection,$qList);


            // (bi) Playlist is empty
            if (mysqli_num_rows($rList)==0){
                echo "<h3 class='CplaylistNeg'>No playlist at the moment!</h3>";
                echo "<a href = 'tracks.php'><p id = 'iVisitTracks' >Visit Tracks Page and add songs to your playlist</p></a>";
                echo "<hr class='ClineB'>";
            }
            // (bii)  Playlist exist - show playlist songs
            else{
                echo "<table class='CPlaylist'>";
                echo "<h3 class='iRec'><i id='iFasPlT2' class='fas'>&#xf381;</i> Playlist </h3><br>";
            echo "<tr>" .
                "<th> Name </th>" . "<th> Audio </th>" . "<th> Descr. </th>" ."<th> <b>Remove</b> </th>". "</tr>";
            while ($rowList = mysqli_fetch_array($rList,MYSQLI_ASSOC)){

                echo
                    "<td>" .
                    $rowList['name'] . "</td> <td>" .
                    "<audio controls> <source src = " . $rowList['sample'] .
                    " type='audio/mpeg'></audio> </td>" . "<td>" .
                    "<a  href = 'tDescription.php?trackId= " . $rowList['track_id'] . "&album=" . $rowList['album'] . "&genre=" . $rowList['genre'] . "'" . "> More..
                        </a></td> <td>
                        <a  href = 'deleteTrack.php?trackId= " . $rowList['track_id'] . "&album=" . $rowList['album'] . "&genre=" . $rowList['genre'] . "'" . "> 
                        <i id='iFasT' class='fas'>&#xf2ed;</i>
                        </a></td></tr> ";

            }
            }
            echo "</table>";

            // === (c) Recommented Playlist ===
            $qRec = "SELECT r.album FROM tracks t, reviews r WHERE r.product_id = t.track_id AND r.name LIKE '" . $user . "' ORDER BY r.review_id DESC";
            $rRec = mysqli_query($connection, $qRec);

            if ($r1 = mysqli_fetch_array($rRec, MYSQLI_ASSOC)) {

                // (a) Chooses the genre of music that has a recently rated.
                $qChose = "SELECT * FROM tracks WHERE genre= '" . $r1['album'] . "' ORDER BY RAND() LIMIT 5";
                $rChose = mysqli_query($connection, $qChose);


                echo "<h3 class='iRec'><i id='iFasP3' class='fas'>&#xf681;</i> Recommented Tracks </h3><br>";
                echo "<table class='iTgen'>";
                echo "<tr>" . "<th> Artist </th>" .
                    "<th> Name </th>" . "<th> Audio </th>" . "<th> Descr. </th>" . "</tr>";

                while ($r10 = mysqli_fetch_array($rChose,MYSQLI_ASSOC)) {
                    echo
                        "<td>" . $r10['artist'] .
                        "</td>" . "<td>" .
                        $r10['name'] . "</td> <td>" .
                        "<audio controls> <source src = " . $r10['sample'] .
                        " type='audio/mpeg'></audio></i> </td>" . "<td>" .
                        "<a  href = 'tDescription.php?trackId= " . $r10['track_id'] . "&album=" . $r10['album'] . "&genre=" . $r10['genre'] . "'" . "> More..
                        </a></td></tr>";
                }
                echo "</table>";
            }
            // (b) No recommented playlist
            else{
                echo "<h3 class='CplaylistNeg'>No recommented tracks!</h3>";
                echo "<hr class='ClineB'>";
            }
?>

    <footer>
        <p>© Alexandros Christou</p>
        <p>2020</p>
    </footer>

</body>
</html>