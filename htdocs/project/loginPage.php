<html>
<head>
<link rel="stylesheet" href="loginStyle.css">
<title> Calgary Art Market </title>
</head>

<body>

<!-- Reference: https://www.youtube.com/watch?v=JDn6OAMnJwQ -->
<form action="loginLogic.php" method="post">

    <h2> LOGIN </h2>

    <?php if(isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error'];?></p>
    <?php } ?>

    <label>User ID</label>
    <input type="text" name="userID" placeholder="Enter User ID">
    <!-- ADD DROP DOWN INPUT FOR EMPL OR CUST -->

    

    <button type="submit">Login</submit>

</form>

</body>
</html>
