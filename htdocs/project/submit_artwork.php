<?php
session_start();
?>

<html>
<head>
<title> Submit Artwork </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>

<div class="div1">
    <button class="button button_home" onclick="location='loginPage.php'">Logout</button>
    <button class="button button_home" onclick="location='index_cust.php'">Home Page</button>

    <h1> Calgary Art Market </h1>
    <h2> Artwork Submission </h2>
</div>

<h3>Submit Original Artwork for Auction</h3>
<form method="post">

    <?php if(isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error'];?></p>
    <?php } ?>

    <label>Title</label>
    <input class="input_v" type="text" name="title" placeholder="Enter Artwork Title">
    <label>Reserve</label>
    <input class="input_v" type="text" name="reserve" placeholder="Enter Reserve">
    <label>Year</label>
    <input class="input_v" type="date" name="title">
    <label>Artist First Name</label>
    <input class="input_v" type="text" name="title" placeholder="Enter Artist First Name">
    <label>Artist Last Name</label>
    <input class="input_v" type="text" name="title" placeholder="Enter Artist Last Name">
    <label>Artist Email</label>
    <input class="input_v" type="text" name="title" placeholder="Enter Artist Email">

    <input class="input_v" type="submit"></submit>

</form>

</body>
</html>


