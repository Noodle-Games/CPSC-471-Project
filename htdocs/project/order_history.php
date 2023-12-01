<html>

<head>
<title> Order History </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>

<button class="button button_home" onclick="location='loginPage.php'">Logout</button>
<button class="button button_home" onclick="location='index_cust.php'">Home Page</button>
<div class="div1">
    <h1> Calgary Art Market </h1>
    <h2> Order History </h2>
</div>

<?php
// Retrieve Session
session_start();
$current_user = $_SESSION['customer_id'];
echo "<h3>Order History For " . $_SESSION['Fname'] . " " . $_SESSION['Lname'] . "</h3>";

// Create SQL connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");
if (mysqli_connect_errno()){
    echo "Failed to connect to SQL".mysqli_connect_error();
}

// Display all receipts
$query = "SELECT * FROM receipt AS R, artwork AS A WHERE R.customer_id = '$current_user' AND R.artwork_id = A.artwork_id";
$receipts = mysqli_query($con, $query);

// Table headings
echo "<table border='1'>
<tr>
<th class=\"th_grey\"> ID </th>
<th class=\"th_grey\"> Title </th>
<th class=\"th_grey\"> Date </th>
<th class=\"th_grey\"> Price </th>
</tr>";

// Looping through select query to display in table
while($row = mysqli_fetch_array($receipts)){
    echo "<tr>";
    echo "<td>" . $row['artwork_id']. "</td>";
    echo "<td>" . $row['title']. "</td>";
    echo "<td>" . $row['date']. "</td>";
    echo "<td>" . $row['price']. "</td>";
    echo "</tr>";
}
echo "</table>";
?>

</body>
</html>


