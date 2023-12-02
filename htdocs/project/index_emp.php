<?php
session_start();

if (isset($_SESSION['employee_id'])){

?>
<html>
<head>
<title> Calgary Art Market </title>
<link rel="stylesheet" href="galleryStyle.css">
</head>

<body>
<div class="div1">
    <button class="button button_home" onclick="location='loginPage.php'">Logout</button>
    <h1> Calgary Art Market </h1>
    <h2> Welcome, <?php echo $_SESSION['Fname'] . " " . $_SESSION['Lname']; ?></h2>
</div>

<!-- START OF MODIFYING PRINT ARTWORK MEGA SECTION -->
<h3> Print Artwork Modify </h3>
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
        echo "<td> <form method=\"post\">  <input style=\"width: 100%;\" type=\"text\" name=\"" . $row['artwork_id'] . "\" placeholder=\"Enter Quantity\"><br><button style=\"width: 100%;\" type=\"submit\">Update Quantity</submit> </form> </td>";
        echo "<td> <form method=\"post\">  <input style=\"width: 100%;\" type=\"text\" name=\"" . $row['artwork_id'] . 'p' ."\" placeholder=\"Enter Price\"><br><button style=\"width: 100%;\" type=\"submit\">Update Price</submit> </form> </td>";
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
    $newPrice = test_input($_POST[$art_id].'p');
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
$query = "SELECT artwork_id FROM artwork";
$artwork_ids = mysqli_query($con, $query);
while($row = mysqli_fetch_array($artwork_ids)){
    if(array_key_exists($row['artwork_id'], $_POST) || array_key_exists($row['artwork_id'] . 'p', $_POST)) { 
        $art_id = $row['artwork_id'];
        update_artwork($art_id, $con);
        header("Location: index_emp.php");
    }
}

display_artwork($artwork_id_search, $con); 

mysqli_close($con);
?>
<!-- END OF MODIFYING PRINT ARTWORK MEGA SECTION -->

</body>
</html>

<?php
}else{
    header("Location: loginPage.php");
    exit();
}
?>

