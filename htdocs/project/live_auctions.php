<html>

<head>
<title> Auctions </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>

<button class="button button_home" onclick="location='loginPage.php'">Logout</button>

<!-- Home Page logic depending on customer to employee -->
<?php if(isset($_SESSION['customer_id'])){ ?>
    <button class="button button_home" onclick="location='index_cust.php'">Home Page</button>
<?php }
else{?>
    <button class="button button_home" onclick="location='index_emp.php'">Home Page</button>
<?php }?>

<div class="div1">
    <h1> Calgary Art Market </h1>
    <h2> Live Auctions </h2>
</div>

</body>
</html>


