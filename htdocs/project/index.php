<html>
<body>


<h1> Welcome to the Gallery </h1>

<?php
    echo "Meet our artists";
?>

<?php

//Create connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");

//Check connection
if (mysqli_connect_errno()){
    echo "Failed to connect to SQL".mysqli_connect_error();
}

// FOR INSERTING DATA
//$sql = "INSERT INTO artist (email, Fname, Lname) VALUES ('yo@girl.com', 'Sara', 'Lynn')";

// if (!mysqli_query($con, $sql)){
//     die ('Error:' . mysqli_error($con));
// }
// else{
//     echo "1 record added";
// }

// FOR SELECTING/DISPLAYING
$result = mysqli_query($con, "SELECT * FROM artist");

echo "<table border='1'>
<tr>
<th> Email </th>
<th> Fname </th>
<th> Lname </th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['email']. "</td>";
    echo "<td>" . $row['Fname']. "</td>";
    echo "<td>" . $row['Lname']. "</td>";
    echo "</tr>";
}
echo "</table>";


mysqli_close($con);
?>


</body>
</html>


