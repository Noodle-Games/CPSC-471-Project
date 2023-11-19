<html>
<body>


<h1> Test </h1>

<?php
    echo "Hello World"
?>

<?php
//Create connection
$con=mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");

//Check connection
if (mysqli_connect_errno()){
    echo "Failed to connect to SQL".mysqli_connect_error();
}
?>

<?php
mysqli_close($con);
?>


</body>
</html>


