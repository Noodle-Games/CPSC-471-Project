<?php
session_start();

if (isset($_SESSION['customer_id'])){

?>
<!DOCTYPE html>
<html>
<head>
<title> Calgary Art Market </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>
<div class="div1">
    <button class="button button_home" onclick="location='loginPage.php'">Logout</button>
    <h1> Calgary Art Market </h1>
    <h2> Welcome, <?php echo $_SESSION['Fname'] . " " . $_SESSION['Lname']; ?></h2>
</div>
<button class="button_header button_blue" onclick="location='print_collection.php'">Print Collection</button>
<button class="button_header button_yellow" onclick="location='live_auctions.php'">Live Auctions</button>
<button class="button_header button_red" onclick="location='submit_artwork.php'">Submit Artwork</button>
<button class="button_header button_grey" onclick="location='administration.php'">Administration</button>

</body>
</html>

<?php
}else{
    header("Location: loginPage.php");
    exit();
}
?>

