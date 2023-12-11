<?php
session_start();
?>

<html>
<head>
<title> Order History </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>


<div class="div1">
    <button class="button button_home" onclick="location='index.php'">Logout</button>
    <button class="button button_home" onclick="location='index_cust.php'">Home Page</button>

    <h1> Calgary Art Market </h1>
</div>
<button class="button_header button_blue" onclick="location='print_collection.php'">Print Collection</button>
<button class="button_header button_yellow" onclick="location='live_auctions.php'">Live Auctions</button>
<button class="button_header button_red" onclick="location='submit_artwork.php'">Submit Artwork</button>
<button class="button_header button_grey current-page" onclick="location='order_history.php'">Order History</button>
<br><br> 

<?php
// Retrieve Session
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

<style>
    .button_grey.current-page  {
        background-color: rgba(170, 170, 170, 0.7);       
    }
</style>


