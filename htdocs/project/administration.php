<?php
session_start();

if (isset($_SESSION['employee_id'])){

?>

<html>
<head>
<title> Administration </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>

<div class="div1">
    
    <button class="button button_home" onclick="location='index.php'">Logout</button>
    <!-- <button class="button button_home" onclick="location='index_emp.php'">Home Page</button> -->
    
    <h1> Calgary Art Market </h1>
    <h2> Welcome, Manager <?php echo $_SESSION['Fname'] . " " . $_SESSION['Lname']; ?></h2>
    <h2> Administrator Console </h2>

</div>

<button class="button_header button_blue" style="width:33.3333%;" onclick="location='admin/emp_info.php'">Employee Info</button>
<button class="button_header button_yellow" style="width:33.3333%;" onclick="location='admin/cust_info.php'">Customer Info</button>
<button class="button_header button_red" style="width:33.3333%;" onclick="location='admin/exhib.php'">Exhibitions</button>

</body>
</html>
<?php
}else{
    header("Location: index.php");
    exit();
}
?>

