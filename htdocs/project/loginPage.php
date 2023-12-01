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
    
    <!-- Drop down menu to pick type of user -->
    <label for="userType">User Type:</label>
    <select name="userType">
        <option value="customer">Customer</option>
        <option value="employee">Employee</option>
    </select>

    <button type="submit">Login</submit>

</form>

</body>
</html>
