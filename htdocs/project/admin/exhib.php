<?php
session_start();
?>

<html>
<head>
<title> Exhibitions </title>
<link rel="stylesheet" href="../galleryStyle.css">
</head>

<body>

<div class="div1">
    
    <button class="button button_home" onclick="location='../index.php'">Logout</button>
    <button class="button button_home" onclick="location='../administration.php'">Home Page</button>
    
    <h1> Calgary Art Market </h1>
    <h2> Exhibition Information </h2>

</div>

<!-- START OF MEGA SECTION -->
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
function display_artwork($art_id, $con){
    $query = "";
    if ($art_id == ""){
        $query = "SELECT * FROM exhibition";
    }
    else {
        $art_id = "\"" . $art_id . "\"";
        $query = "SELECT * FROM exhibiton WHERE artwork_id=$art_id OR artwork_title = $art_id)";
    }
    $prints = mysqli_query($con, $query);
    echo "<table border='1'>
    <tr>
    <th class=\"th_blue\"> Date </th>
    <th class=\"th_blue\"> Store </th>
    <th class=\"th_blue\"> ID </th>
    <th class=\"th_blue\"> Title </th>
    </tr>";
    while($row = mysqli_fetch_array($prints)){
        echo "<tr>";
        echo "<td>" . $row['Date']. "</td>";
        echo "<td>" . $row['store_id']. "</td>";
        echo "<td>" . $row['artwork_id']. "</td>";
        echo "<td>" . $row['artwork_title']. "</td>";
        echo "<td> <form method=\"post\">  <input style=\"width: 100%;\" type=\"text\" name=\"" . $row['artwork_id'] . "\" placeholder=\"Enter Quantity\"><br><button style=\"width: 100%;\" type=\"submit\">Update Quantity</submit> </form> </td>";
        echo "</tr>";
    }
    echo "</table>";
}

function update_artwork($art_id, $con){

    // Update quantity
    $newQuantity = test_input($_POST[$art_id]);
    $artid = "\"" . $art_id . "\"";
    $query = "UPDATE print AS P SET P.quantity = $newQuantity WHERE P.artwork_id = $artid";
    mysqli_query($con, $query);

    // Update price
    $newPrice = test_input($_POST[$art_id."p"]);
    $artid = "\"" . $art_id . "\"";
    $query = "UPDATE print AS P SET P.price = $newPrice WHERE P.artwork_id = $artid";
    mysqli_query($con, $query);
}
?>

<!--Reference 1-->
<!-- Search Artwork -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Search Artwork ID or Title: <input type="text" name="artwork_id_search" value="<?php echo $artwork_id_search;?>">
    <input type="submit" name="submit" value="Search">
    <span> <?php echo $artworkErr;?></span>
</form>
<!--Reference 1-->

<?php 

// Checking for artwork changes input
$query = "SELECT artwork_id FROM exhibition";
$artwork_ids = mysqli_query($con, $query);
while($row = mysqli_fetch_array($artwork_ids)){
    if(array_key_exists($row['artwork_id'], $_POST)) { 
        $art_id = $row['artwork_id'];
        update_artwork($art_id, $con);
        header("Location: exhib.php");
    }
}

display_artwork($artwork_id_search, $con);


?>
<!-- END OF MEGA SECTION -->

<h3> Add New Exhibition Piece </h3>
<!-- Form to enter new exhibiton piece -->
<form method="post">
    <?php if(isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error'];?></p>
    <?php } ?>
    <label>Exhibition Date</label>
    <input class="input_v" type="date" name="Date">

    <label>Store ID</label>
    <input class="input_v" type="text" name="store_id" placeholder="Enter Store ID">

    <label>Artwork ID</label>
    <input class="input_v" type="text" name="artwork_id" placeholder="Enter Artwork ID">

    <label>Artwork Title</label>
    <input class="input_v" type="text" name="artwork_title" placeholder="Enter Artwork Title">
    <input class="input_v" type="submit"></input>
</form>

<?php
function add_exhib($date, $store_id, $art_id, $art_title, $con){
    $query = "SELECT artwork_id FROM exhibition";
    $result = mysqli_query($con, $query);
    $result = $result->fetch_all();
    $art_ids = array();
    foreach($result as $val){
        array_push($art_ids, $val[0]);
    }

    if (!in_array($art_id, $art_ids)){
        $query = "INSERT INTO exhibition VALUES (\"$date\", \"$store_id\", \"$art_id\", \"$art_title\")";
        mysqli_query($con, $query);
    }
}

// Validate form input
if (array_key_exists('artwork_id', $_POST)){
    $date = test_input($_POST['Date']);
    $store_id = test_input($_POST['store_id']);
    $art_id = test_input($_POST['artwork_id']);
    $art_title = test_input($_POST['artwork_title']);

    if (!empty($date) and !empty($store_id) and !empty($art_id) and !empty($art_title)){
        add_exhib($date, $store_id, $art_id, $art_title, $con);
        header("Location: exhib.php");
    }
    else {
        echo "Please fill out every field before submitting";
    }
}

mysqli_close($con);
?>

</body>
</html>