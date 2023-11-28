<html>

<head>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>
<button class="button button_home" onclick="location='index.php'">Home Page</button>
<div class="div1">
    <h1> Calgary Art Market </h1>
    <h2> Print Collection </h2>
</div>
<h3>Meet Our Artists</h3>

<?php
// Create SQL connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");

// Check SQL connection
if (mysqli_connect_errno()){
    echo "Failed to connect to SQL".mysqli_connect_error();
}

// ARTIST DISPLAY
$query = "SELECT * FROM artist";
$artists = mysqli_query($con, $query);

// Table headings
echo "<table border='1'>
<tr>
<th class=\"th_blue\"> Email </th>
<th class=\"th_blue\"> First </th>
<th class=\"th_blue\"> Last </th>
</tr>";

// Looping through select query to display in table
while($row = mysqli_fetch_array($artists)){
    echo "<tr>";
    echo "<td>" . $row['email']. "</td>";
    echo "<td>" . $row['Fname']. "</td>";
    echo "<td>" . $row['Lname']. "</td>";
    echo "</tr>";
}
echo "</table>";

// SEARCH FUNCTION
$artwork_id_search = $artworkErr = "";
// Reference 1: https://www.w3schools.com/php/php_form_complete.asp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $artwork_id_search = test_input($_POST["artwork_id_search"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z0-9' ]*$/",$artwork_id_search)) {
        $artworkErr = "Only letters, numbers, and white space allowed";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// SQL query to display artwork
function display_artwork($art_id, $con){
    $query = "";
    if ($art_id == ""){
        $query = "SELECT * FROM artwork AS A, print AS P, store AS S WHERE P.artwork_id = A.artwork_id AND A.store_id = S.store_id";
    }
    else {
        $art_id = "\"" . $art_id . "\"";
        $query = "SELECT * FROM artwork AS A, print AS P, store AS S WHERE P.artwork_id = A.artwork_id AND A.store_id = S.store_id AND (A.title = $art_id OR A.artwork_id = $art_id)";
    }
    $prints = mysqli_query($con, $query);
    echo "<table border='1'>
    <tr>
    <th class=\"th_blue\"> ID </th>
    <th class=\"th_blue\"> Title </th>
    <th class=\"th_blue\"> Price </th>
    <th class=\"th_blue\"> Year </th>
    <th class=\"th_blue\"> Artist Contact </th>
    <th class=\"th_blue\">  Location </th>
    <th class=\"th_blue\"> Stock </th>
    <th class=\"th_blue\"> </th>
    </tr>";
    while($row = mysqli_fetch_array($prints)){
        echo "<tr>";
        echo "<td>" . $row['artwork_id']. "</td>";
        echo "<td>" . $row['title']. "</td>";
        echo "<td>" . $row['price']. "</td>";
        echo "<td>" . $row['year']. "</td>";
        echo "<td>" . $row['artist_email']. "</td>";
        echo "<td>" . $row['store_name']. "</td>";
        echo "<td>" . $row['quantity']. "</td>";
        echo "<td> <button class=\"button_buy\">Buy</button> </td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<h3>Print Artwork Inventory</h3>

<!--Reference 1-->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Search Artwork ID or Title: <input type="text" name="artwork_id_search" value="<?php echo $artwork_id_search;?>">
    <input type="submit" name="submit" value="Search">
    <span> <?php echo $artworkErr;?></span>
</form>
<!--Reference 1-->

<?php 
display_artwork($artwork_id_search, $con); 
mysqli_close($con);
?>

</body>
</html>


