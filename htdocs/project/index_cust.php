<?php
session_start();

if (isset($_SESSION['customer_id'])){

?>

<html>
<head>
<title> Calgary Art Market </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>
<div class="div1">
    <button class="button button_home" onclick="location='index.php'">Logout</button>
    <h1> Calgary Art Market </h1>
    <h2> Welcome, <?php echo $_SESSION['Fname'] . " " . $_SESSION['Lname']; ?></h2>
</div>
<button class="button_header button_blue" onclick="location='print_collection.php'">Print Collection</button>
<button class="button_header button_yellow" onclick="location='live_auctions.php'">Live Auctions</button>
<button class="button_header button_red" onclick="location='submit_artwork.php'">Submit Artwork</button>
<button class="button_header button_grey" onclick="location='order_history.php'">Order History</button>

<br><br>
<h3> Exhibitions </h3>

<!-- EXHIBITION LOGIC -->
<?php
// Create SQL connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");
if (mysqli_connect_errno()){
    echo "Failed to connect to SQL".mysqli_connect_error();
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// SEARCH FUNCTION
$artwork_id_search = $artworkErr = "";
// Reference 1: https://www.w3schools.com/php/php_form_complete.asp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(array_key_exists('artwork_id_search', $_POST)){
        $artwork_id_search = test_input($_POST["artwork_id_search"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9' ]*$/",$artwork_id_search)) {
            $artworkErr = "Only letters, numbers, and white space allowed";
        }
    }
}
// SQL query to display artwork
function display_exhib($art_id, $con){
    $query = "";
    if ($art_id == ""){
        $query = "SELECT * FROM exhibition AS E, original AS O, store AS S WHERE E.artwork_id = O.artwork_id AND E.store_id = S.store_id";
    }
    else {
        $art_id = "\"" . $art_id . "\"";
        $query = "SELECT * FROM exhibition AS E, original AS O, store AS S WHERE E.artwork_id = O.artwork_id AND E.store_id = S.store_id AND (E.artwork_title = $art_id OR E.artwork_id = $art_id)";
    }
    $prints = mysqli_query($con, $query);
    echo "<table border='1'>
    <tr>
    <th class=\"th_blue\"> ID </th>
    <th class=\"th_blue\"> Title </th>
    <th class=\"th_blue\"> Location </th>
    <th class=\"th_blue\"> Date </th>
    <th class=\"th_blue\"> </th>
    </tr>";
    while($row = mysqli_fetch_array($prints)){
        echo "<tr>";
        echo "<td>" . $row['artwork_id']. "</td>";
        echo "<td>" . $row['artwork_title']. "</td>";
        echo "<td>" . $row['store_name']. "</td>";
        echo "<td>" . $row['Date']. "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

?>

<!-- Search Artwork -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Search Artwork ID or Title: <input type="text" name="artwork_id_search" value="<?php echo $artwork_id_search;?>">
    <input type="submit" name="submit" value="Search">
    <span> <?php echo $artworkErr;?></span>
</form>

<?php
display_exhib($artwork_id_search, $con); 
mysqli_close($con);
?>

</body>
</html>

<?php
}else{
    header("Location: loginPage.php");
    exit();
}
?>

