<?php session_start();?>
<?php


    $conxion = mysqli_connect('localhost','achristou4','HznB6091','achristou4');
    $qReview = "SELECT * FROM reviews";
    $rReview = mysqli_query($conxion,$qReview);

   // echo $_POST['review'];
    if (isset($_POST['rate'])){

        $_SESSION['rate'] = $_POST['rate'];

    }
if (isset($_POST['review'])){

    $_SESSION['review'] = $_POST['review'];
}

    //while ($row = mysqli_fetch_array($rReview,MYSQLI_ASSOC)) {

        if ($_SESSION['checkLogin'] == 2){
            $name = $_SESSION['username'];
        }else{
            $name = $_SESSION['s_username'];
        }
        $productID = $_SESSION['trackId'];
        $rate = $_POST['rate'];
        $review = $_POST['review'];

        echo $review;
if (isset($_GET['album'])){
    $_SESSION['album'] = $_GET['album'];
}
if (isset($_GET['trackId'])){
    $_SESSION['trackId'] = $_GET['trackId'];
}
if (isset($_GET['genre'])){
    $_SESSION['genre'] = $_GET['genre'];
}
        $alb = $_SESSION['genre'];
        echo $alb." = GENRE<br>";

        $addReview = "INSERT INTO reviews(product_id,name,rating,review,album) VALUES ($productID,'$name',$rate,'$review','$alb')";
        $qAddReview = mysqli_query($conxion,$addReview);
//        if ($conxion->query($addReview) === TRUE){
//            echo "query added1";
//        }

//        exec($qAddReview);
//        echo $qAddReview;
//        echo $addReview;
       header('location:tDescription.php?trackId='.$_SESSION['trackId']."&album=".$_SESSION['album']."&genre=".$_SESSION['genre']);
    //}
?>