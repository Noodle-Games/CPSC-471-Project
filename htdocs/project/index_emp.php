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
    <button class="button button_home" onclick="location='index.php'">Logout</button>
    <h1> Calgary Art Market </h1>
    <h2> Welcome, <?php echo $_SESSION['Fname'] . " " . $_SESSION['Lname']; ?></h2>
</div>

<!-- START OF MODIFYING PRINT ARTWORK MEGA SECTION ---------------------->
<h3> Modify Print Artwork </h3>
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
        echo "<td> <form method=\"post\">  <input style=\"width: 100%;\" type=\"text\" name=\"" . $row['artwork_id'] . "p" ."\" placeholder=\"Enter Price\"><br><button style=\"width: 100%;\" type=\"submit\">Update Price</submit> </form> </td>";
        echo "</tr>";
    }
    echo "</table>";
}

function update_quantity($art_id, $con){
    $newQuantity = test_input($_POST[$art_id]);
    if(empty($newQuantity)) return;

    $artid = "\"" . $art_id . "\"";
    $query = "UPDATE print AS P SET P.quantity = $newQuantity WHERE P.artwork_id = $artid";
    mysqli_query($con, $query);
}

function update_price($art_id, $con){
    $newPrice = test_input($_POST[$art_id."p"]);
    if(empty($newPrice)) return;


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
    if(array_key_exists($row['artwork_id'], $_POST)) { 
        $art_id = $row['artwork_id'];
        update_quantity($art_id, $con);
        header("Location: index_emp.php");
    }
    if(array_key_exists($row['artwork_id'] . 'p', $_POST)) { 
        $art_id = $row['artwork_id'];
        update_price($art_id, $con);
        header("Location: index_emp.php");
    }
}

display_artwork($artwork_id_search, $con); 
?>
<!-- END OF MODIFYING PRINT ARTWORK MEGA SECTION ---------------------->


<!-- START OF MODIFYING ORIGINAL ARTWORK MEGA SECTION ----------------->
<h3> Modify Original Artwork </h3>
<?php

// SEARCH FUNCTION
$original_id_search = $originalErr = "";
// Reference 1: https://www.w3schools.com/php/php_form_complete.asp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(array_key_exists('original_id_search', $_POST)){
        $original_id_search = test_input($_POST["original_id_search"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9' ]*$/",$original_id_search)) {
            $originalErr = "Only letters, numbers, and white space allowed";
        }
    }
}

// SQL query to display original artwork
function display_original($art_id, $con){
    $query = "";
    if ($art_id == ""){
        $query = "SELECT * FROM artwork AS A, original AS O, store as S WHERE A.store_id = S.store_id AND O.artwork_id = A.artwork_id";
    }
    else {
        $art_id = "\"" . $art_id . "\"";
        $query = "SELECT * FROM artwork AS A, original AS O, store AS S WHERE O.artwork_id = A.artwork_id AND A.store_id = S.store_id AND (A.title = $art_id OR A.artwork_id = $art_id)";
    }
    $prints = mysqli_query($con, $query);
    echo "<table border='1'>
    <tr>
    <th class=\"th_blue\"> ID </th>
    <th class=\"th_blue\"> Title </th>
    <th class=\"th_blue\"> Reserve Amount </th>
    <th class=\"th_blue\"> Year </th>
    <th class=\"th_blue\"> Artist Contact </th>
    <th class=\"th_blue\"> Location </th>
    <th class=\"th_blue\"> Approval</th>
    <th class=\"th_blue\"> </th>
    <th class=\"th_blue\"> </th>
    <th class=\"th_blue\"> </th>
    </tr>";
    while($row = mysqli_fetch_array($prints)){
        echo "<tr>";
        echo "<td>" . $row['artwork_id']. "</td>";
        echo "<td>" . $row['title']. "</td>";
        echo "<td style=\"text-align:center;\">" . $row['reserve']. "</td>";
        echo "<td>" . $row['year']. "</td>";
        echo "<td>" . $row['artist_email']. "</td>";
        echo "<td>" . $row['store_name']. "</td>";
        echo "<td style=\"text-align:center;\">" . $row['approved']. "</td>";
        echo "<td> <form method=\"post\"> <input style=\"width: 100%;\" type=\"text\" name=\"" . $row['artwork_id'] . "\" placeholder=\"Enter Reserve Price\"><br><button style=\"width: 100%;\" type=\"submit\">Update Reserve</submit> </form> </td>";
        echo "<td> <form method=\"post\"> <select name=\"" . $row['artwork_id'] . "a" . "\"> <option value=\"unapprove\">Unapprove</option> <option value=\"approve\">Approve</option> </select> <br><button style=\"width: 80%;\" type=\"submit\">Update Approval</submit> </form> </td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Query to update the reserve price for an original
function update_reserve($art_id, $con) {
    $newReserve = test_input($_POST[$art_id]);
    if(empty($newReserve)) return;

    //$artid = "\"" . $art_id . "\"";
    $query1 = "UPDATE original SET reserve = ? WHERE artwork_id = ?";
    $query2 = "UPDATE auction SET starting_bid = ? WHERE artwork_id = ?";
    
    $updateOriginal = $con->prepare($query1);
    $updateOriginal->bind_param("ds", $newReserve, $art_id);
    $updateOriginal->execute();
    $updateOriginal->close();

    $updateAuction = $con->prepare($query2);
    $updateAuction->bind_param("ds", $newReserve, $art_id);
    $updateAuction->execute();
    $updateAuction->close();
}

// Query to update the approval status for an original
function update_approval($art_id, $con) {

    // Update approval status
    $newApproval = test_input($_POST[$art_id . "a"]);
    $query2 = "";

    if ($newApproval == "approve") {
        $query2 = "UPDATE original SET approved = '1' WHERE artwork_id = ?";

        $getOwnerIdQuery = "SELECT owner_id FROM original WHERE artwork_id = ?";
        $getOwnerIdStatement = $con->prepare($getOwnerIdQuery);
        $getOwnerIdStatement->bind_param("s", $art_id);
        $getOwnerIdStatement->execute();
        $getOwnerIdStatement->bind_result($owner_id);
        $getOwnerIdStatement->fetch();
        $getOwnerIdStatement->close();

        // Fetch the updated reserve value
        $getReserveQuery = "SELECT reserve FROM original WHERE artwork_id = ?";
        $getReserveStatement = $con->prepare($getReserveQuery);
        $getReserveStatement->bind_param("s", $art_id);
        $getReserveStatement->execute();
        $getReserveStatement->bind_result($reserve);
        echo $reserve;
        $getReserveStatement->fetch();
        $getReserveStatement->close();

        // Insert into Auctions table
        $insertAuctionQuery = "INSERT INTO auction (customer_id, artwork_id, starting_bid, highest_bid, start_date, end_date) VALUES (?, ?, ?, 0, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 20 DAY))";
        $insertAuctionStatement = $con->prepare($insertAuctionQuery);
        $insertAuctionStatement->bind_param("ssd", $owner_id, $art_id, $reserve);

        if ($insertAuctionStatement->execute()) {
            echo "Approval status updated and record inserted into Auctions successfully!";
        } else {
            echo "Error inserting record into Auctions: " . $insertAuctionStatement->error;
        }

        $insertAuctionStatement->close();
    } else {
        $query2 = "UPDATE original SET approved = '0' WHERE artwork_id = ?";
        $query3 = "DELETE FROM auction WHERE artwork_id = \"$art_id\"";
        $auctionDelete = $con->prepare($query3);
        $auctionDelete->execute();
        $auctionDelete->close();
    }

    $updateApproval = $con->prepare($query2);
    $updateApproval->bind_param("s", $art_id);
    $updateApproval->execute();
    $updateApproval->close();
}

?>

<!--Reference 1-->
<!-- Search Artwork -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Search Artwork ID or Title: <input type="text" name="original_id_search" value="<?php echo $original_id_search;?>">
    <input type="submit" name="submit" value="Search">
    <span> <?php echo $originalErr;?></span>
</form>
<!--Reference 1-->

<?php 

// Checking for artwork changes input
$query = "SELECT artwork_id FROM original";
$original_ids = mysqli_query($con, $query);
while($row = mysqli_fetch_array($original_ids)){
    // Checking to update reserve
    if(array_key_exists($row['artwork_id'], $_POST)) { 
        $art_id = $row['artwork_id'];
        update_reserve($art_id, $con);
        header("Location: index_emp.php");
    }
    // Checking to update approval
    if(array_key_exists($row['artwork_id'] . 'a', $_POST)) { 
        $art_id = $row['artwork_id'];
        update_approval($art_id, $con);
        header("Location: index_emp.php");
    }
}

display_original($original_id_search, $con); 

?>
<!-- END OF MODIFYING ORIGINAL ARTWORK MEGA SECTION ----------------->


<!-- START OF AUCTION MEGA SECTION ----------------------------------->
<h3> Live Auctions </h3>
<?php

// SEARCH FUNCTION
$auction_id_search = $auctionErr = "";
// Reference 1: https://www.w3schools.com/php/php_form_complete.asp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(array_key_exists('auction_id_search', $_POST)){
        $auction_id_search = test_input($_POST["auction_id_search"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9' ]*$/",$auction_id_search)) {
            $auctionErr = "Only letters, numbers, and white space allowed";
        }
    }
}

// SQL query to display current auctions
function display_auction($art_id, $con){
    $query = "";
    if ($art_id == ""){
        $query = "SELECT * FROM auction AS A, artwork AS O WHERE A.artwork_id = O.artwork_id";
    }
    else {
        $art_id = "\"" . $art_id . "\"";
        $query = "SELECT * FROM auction AS A, artwork AS O WHERE A.artwork_id = O.artwork_id AND (O.title = $art_id OR O.artwork_id = $art_id)";
    }
    $prints = mysqli_query($con, $query);
    echo "<table border='1'>
    <tr>
    <th class=\"th_blue\"> ID </th>
    <th class=\"th_blue\"> Title </th>
    <th class=\"th_blue\"> Starting Bid </th>
    <th class=\"th_blue\"> Highest Bid </th>
    <th class=\"th_blue\"> Start Date </th>
    <th class=\"th_blue\"> End Date </th>
    <th class=\"th_blue\"> </th>
    </tr>";
    while($row = mysqli_fetch_array($prints)){
        echo "<tr>";
        echo "<td>" . $row['artwork_id']. "</td>";
        echo "<td>" . $row['title']. "</td>";
        echo "<td>" . $row['starting_bid']. "</td>";
        echo "<td>" . $row['highest_bid']. "</td>";
        echo "<td>" . $row['start_date']. "</td>";
        echo "<td>" . $row['end_date']. "</td>";
        echo "<td> <form method=\"post\"> <input style=\"width: 100%;\" type=\"submit\" name=\"". $row['artwork_id'] . "e" . "\" value=\"End Auction\"> </form> </td>";
        echo "</tr>";
    }
    echo "</table>";
}

// End an auction and send receipt
function end_auction($art_id, $con) {

    // Get highest bidder info
    $bidderIDQuery = "SELECT customer_id FROM bids WHERE artwork_id = ? AND bid_price = (SELECT MAX(bid_price) FROM bids WHERE artwork_id = ?)";
    $getAmount = $con->prepare($bidderIDQuery);
    $getAmount->bind_param("ss", $art_id,$art_id);
    $getAmount->execute();
    $getAmount->bind_result($highest_bidder);
    $getAmount->fetch();
    $getAmount->close();

    $amountQuery = "SELECT MAX(bid_price) FROM bids WHERE artwork_id = ?";
    $getAmount = $con->prepare($amountQuery);
    $getAmount->bind_param("s", $art_id);
    $getAmount->execute();
    $getAmount->bind_result($price);
    $getAmount->fetch();
    $getAmount->close();

    // Creating a receipt for the winner
    $query1 = "INSERT INTO receipt VALUES (?, ?, NOW(), ?)";
    $newReceipt = $con->prepare($query1);
    $newReceipt->bind_param("ssd", $art_id, $highest_bidder, $price);
    $newReceipt->execute();
    $newReceipt->close();

    $query9 = "DELETE FROM bids WHERE artwork_id = ?";
    $deleteBids = $con->prepare($query9);
    $deleteBids->bind_param("s", $art_id);

if ($deleteBids->execute()) {
    $deleteBids->close();
    // Remove auction
    $query2 = "DELETE FROM auction WHERE artwork_id = ?";
    $removeAuction = $con->prepare($query2);
    $removeAuction->bind_param("s", $art_id);
    $removeAuction->execute();
    $removeAuction->close();
    }

    $query10 = "DELETE FROM original WHERE artwork_id = ?";
    $deleteOG = $con->prepare($query10);
    $deleteOG->bind_param("s", $art_id);
    $deleteOG->execute();
    $deleteOG->close();

}

?>

<!--Reference 1-->
<!-- Search Artwork -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Search Artwork ID or Title: <input type="text" name="auction_id_search" value="<?php echo $auction_id_search;?>">
    <input type="submit" name="submit" value="Search">
    <span> <?php echo $auctionErr;?></span>
</form>
<!--Reference 1-->

<?php 

// Checking for artwork changes input
$query = "SELECT artwork_id FROM auction";
$auction_ids = mysqli_query($con, $query);
while($row = mysqli_fetch_array($auction_ids)){
    if(array_key_exists($row['artwork_id'] . "e", $_POST)) { 
        $art_id = $row['artwork_id'];
        
        end_auction($art_id, $con);
        //header("Location: index_emp.php");
        exit();
        
    }
}

display_auction($auction_id_search, $con);

mysqli_close($con);
?>
<!-- END OF AUCTION MEGA SECTION ----------------------------------->

</body>
</html>

<?php
}else{
    header("Location: index.php");
    exit();
}
?>

