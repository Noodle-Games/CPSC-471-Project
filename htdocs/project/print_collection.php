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

<h2>Meet our artists</h2>

<?php

// Create SQL connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");

// Check SQL connection
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

// Table headings
echo "<table border='2'>
<tr>
<th> Email </th>
<th> Fname </th>
<th> Lname </th>
</tr>";

// Looping through select query to display in table
while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['email']. "</td>";
    echo "<td>" . $row['Fname']. "</td>";
    echo "<td>" . $row['Lname']. "</td>";
    echo "</tr>";
}
echo "</table>";

// SEARCH FUNCTION
// Search variables
$artwork_id_search = $artworkErr = "";

// Reference 1: https://www.w3schools.com/php/php_form_complete.asp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["artwork_id_search"])) {
      $artworkErr = "Please Enter an artwork ID";
    } else {
      $artwork_id_search = test_input($_POST["artwork_id_search"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z0-9' ]*$/",$artwork_id_search)) {
        $artworkErr = "Only letters, numbers, and white space allowed";
      }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// SQL query to display artwork
function display_artwork($art_id){

    $artwork_result = mysqli_query($con, "SELECT * FROM artwork");

    echo "<table border='2'>
    <tr>
    <th> Artwork ID </th>
    <th> Year </th>
    <th> Artist Email </th>
    <th> Store ID </th>
    </tr>";

    while($row = mysqli_fetch_array($artwork_result)) {
        echo "<tr>";
        echo "<td>" . $row['artwork_ID']. "</td>";
        echo "<td>" . $row['year']. "</td>";
        echo "<td>" . $row['artist_email']. "</td>";
        echo "<td>" . $row['store_id']. "</td>";
        echo "</tr>";
    }
    
    echo "Hello";
}

?>

<!--Reference 1-->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <br><br>
    Search Artwork: <input type="text" name="artwork_id_search" value="<?php echo $artwork_id_search;?>">
    <span> <?php echo $artworkErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Search">
</form>

<!--Reference 1-->
<?php
echo "<h2>Input Check:</h2>";
echo $artwork_id_search;
echo "<br><br>";

//display_artwork($artwork_id_search);
?>

<?php 
// Close Connection
mysqli_close($con);
?>

</body>
</html>

