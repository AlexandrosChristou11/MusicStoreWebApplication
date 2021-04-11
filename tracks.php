<?php session_start();
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
            <a class="navbar-brand" href="home.php"><i id="iFasTracks" class='fas'>&#xf86d;</i></a><!--         Greeting to the user-->
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

    <hr class="cLineTracks">
    <h1 id="iTracks"> TRACKS </h1>
    <hr  class="cLineTracks">
    <br>
    <!-- (a)  FILTER BY ARTIST    -->
    <?php
    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $qNameTracks = "SELECT DISTINCT  artist FROM tracks";
    $rNameTracks = mysqli_query($connection,$qNameTracks);

    echo "<form class='Cfilter' action='#' method='post'>";
     echo "<label class='Clabel'>Search By Artist</label><br>";
    echo "<select name='nArtist'>";
    while ($rowNameTracks = mysqli_fetch_array($rNameTracks,MYSQLI_ASSOC)){
        echo"
        
        <option name='".$rowNameTracks['artist']."'
         value='".$rowNameTracks['artist']."'>".$rowNameTracks['artist']."</option>
       ";

    }
    echo "</select>";
    echo " <button type=\"submit\" name='submit' value='Filter' class=\"btn btn-default\">Filter</button>
  
        </form>";
   if (isset($_POST['nArtist'])) {
       $selected_val = $_POST['nArtist'];
       //     echo $selected_val;

       $qArtist = "SELECT * FROM tracks WHERE artist ='" . $_POST['nArtist'] . "'";
       $rArtist = mysqli_query($connection, $qArtist);

       echo "<table class='CfilterTable'>";
       echo "<tr>" .  "<th> Artist </th>" . "<th> Album </th>" .
           "<th> Name </th>" ."<th> Descr.</th>". "</tr>";

       while ($r = mysqli_fetch_array($rArtist, MYSQLI_ASSOC)) {
           echo

               "<td><b>" . $r['artist'] .
               "</b></td>" . "<td>" . $r['album'] . "</td>" . "<td>" . $r['name'] . "</td>" . "<td>".
               "<a  href = 'tDescription.php?trackId=".$r['track_id']."&album=".$r['album']."&genre=".$r['genre']."'"."> More..
                        </a></td></tr>";

           // echo "</table>";
       }
       echo "</table>";
       echo "</div>";


   }
    ?>
    <!-- (b)  FILTER BY Album    -->
    <?php
    $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $qNameTracks = "SELECT DISTINCT  album FROM tracks";
    $rNameTracks = mysqli_query($connection,$qNameTracks);

    echo "<form class='Cfilter' action='#' method='post'>";
    echo "<label class='Clabel'>Search By Album</label><br>";
    echo "<select name='nAlbum'>";
    while ($rowNameTracks = mysqli_fetch_array($rNameTracks,MYSQLI_ASSOC)){
        echo"
        
        <option name='".$rowNameTracks['album']."'
         value='".$rowNameTracks['album']."'>".$rowNameTracks['album']."</option>
       ";

    }
    echo "</select>";
    echo "<br>  <button  type=\"submit\" name='submit' value='Filter' class=\"btn btn-default\">Filter</button>
        </form>";
    if (isset($_POST['nAlbum'])) {
        $selected_val = $_POST['nAlbum'];
        //     echo $selected_val;

        $qAlbum = "SELECT * FROM tracks WHERE album ='" . $_POST['nAlbum'] . "'";
        $rAlbum = mysqli_query($connection, $qAlbum);

        echo "<table class='CfilterTable'>";
        echo "<tr>" .  "<th> Artist </th>" . "<th> Album </th>" .
            "<th> Name </th>" ."<th> Descr. </th>". "</tr>";

        while ($r3 = mysqli_fetch_array($rAlbum, MYSQLI_ASSOC)) {
            echo
                "<td>" . $r3['artist'] .
                "</td>" . "<td><b>" . $r3['album'] . "</b></td>" . "<td>" . $r3['name'] . "</td> <td>" .

                "<a  href = 'tDescription.php?trackId=".$r3['track_id']."&album=".$r3['album']."&genre=".$r3['genre']."'"."> More..
                        </a></td></tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    ?>

<?php

        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        // Queries
        $connection = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
        $qTracksDistinct = "SELECT DISTINCT genre FROM tracks";
        $qTracksAll = "SELECT * FROM tracks";
        $rTracksAll = mysqli_query($connection,$qTracksAll);
        $rTracksDistinct = mysqli_query($connection,$qTracksDistinct);
        $validator = 0;

                // (a) All Tracks
            echo "<button type='button' class='collapsible'>" . "ALL Tracks" . "</button>";
            echo "<div class= 'content'>";
            echo "<table>";
            echo "<tr>" .  "<th> Artist </th>" . "<th> Album </th>" . "<th> Name </th>" .
               "<th> Descr. </th>". "</tr>";
            while ($rowTracksALL = mysqli_fetch_array($rTracksAll, MYSQLI_ASSOC)) {
                echo  "<td>" . $rowTracksALL['artist'] .
                    "</td>" . "<td>" . $rowTracksALL['album'] . "</td>" . "<td>" . $rowTracksALL['name'] . "<td>".
                        "<a  href = 'tDescription.php?trackId=".$rowTracksALL['track_id']."&album=".$rowTracksALL['album']."&genre=".$rowTracksALL['genre']."'"."> More..
                        </a></td></tr>";
            }
            echo "</table>";
            echo "</div>";

            // (b) Tracks By Genre
            // ======== EXECUTE TRACK LIST =========
            while ($row = mysqli_fetch_array($rTracksDistinct, MYSQLI_ASSOC)) {

                echo "<button type='button' class='collapsible'>" . $row['genre'] . "</button>";
                echo "<div class= 'content'>";
                $qTracksByGenre = "SELECT * FROM tracks WHERE genre='" . $row['genre'] . "'";
                $rTracksByGenre = mysqli_query($connection, $qTracksByGenre);

                echo "<table class='Cgenre' >";
                echo "<tr>" .  "<th> Artist </th>" . "<th> Album </th>" .
                    "<th> Name </th>" ."<th> Descr. </th>". "</tr>";


                while ($rowTracks = mysqli_fetch_array($rTracksByGenre, MYSQLI_ASSOC)) {
                    echo
                        "<td>" . $rowTracks['artist'] .
                        "</td>" . "<td>" . $rowTracks['album'] . "</td>" . "<td>" . $rowTracks['name'] . "</td>" . "<td>".
                        "<a  href = 'tDescription.php?trackId=".$rowTracks['track_id']."&album=".$rowTracks['album']."&genre=".$rowTracks['genre']."'"."> More..
                        </a></td></tr>";
                }
                echo "</table>";
                echo "</div>";


            // ======================================

            }

?>

<script>
    let coll = document.getElementsByClassName('collapsible');
    let i;

    for (i = 0; i < coll.length; i++) {

        coll[i].addEventListener("click", function() {
            this.classList.toggle('active');
            let content = this.nextElementSibling;
            if (content.style.maxHeight){
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }

</script>
<!-- REFERENCE -->
<!--  W3schools.com. 2020. Tryit Editor V3.6. [online] Available at:
 <https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_accordion>
 [Accessed 11 April 2020]. -->



<footer>
    <p>© Alexandros Christou</p>
    <p>2020</p>
</footer>

</body>
</html>