<?php session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HomePage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php

if (isset($_SESSION['checkLogin'])){
    $ad=   $_SESSION['checkLogin'];
}

$_SESSION['checkLogin'] = 1;
 header('location:home.php');
?>

</body>
</html>



