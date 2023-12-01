<?php
session_start();

if (isset($_SESSION['employee_id'])){

?>
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

<h3> Print Artwork Modify </h3>



</body>
</html>

<?php
}else{
    header("Location: loginPage.php");
    exit();
}
?>

