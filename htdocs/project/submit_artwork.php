<?php
session_start();
?>

<html>
<head>
<title> Submit Artwork </title>
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
<button class="button_header button_red current-page" onclick="location='submit_artwork.php'">Submit Artwork</button>
<button class="button_header button_grey" onclick="location='order_history.php'">Order History</button>
<br><br> 
<h3>Submit Original Artwork for Auction</h3>

<form method="post">
    <?php if(isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error'];?></p>
    <?php } ?>
    <label>Title</label>
    <input class="input_v" type="text" name="title" placeholder="Enter Artwork Title">
    <label>Reserve</label>
    <input class="input_v" type="number" name="reserve" placeholder="Enter Reserve">
    <label>Year</label>
    <input class="input_v" type="date" name="year">
    <label>Artist First Name</label>
    <input class="input_v" type="text" name="Fname" placeholder="Enter Artist First Name">
    <label>Artist Last Name</label>
    <input class="input_v" type="text" name="Lname" placeholder="Enter Artist Last Name">
    <label>Artist Email</label>
    <input class="input_v" type="text" name="email" placeholder="Enter Artist Email">
    <input class="input_v" type="submit"></input>
</form>

<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function create_artist($email, $Fname, $Lname, $con){
    $query = "SELECT email FROM artist";
    $result = mysqli_query($con, $query);
    $result = $result->fetch_all();
    $emails = array();
    foreach($result as $val){
        array_push($emails, $val[0]);
    }

    if (!in_array($email, $emails)){
        $query = "INSERT INTO artist VALUES (\"$email\", \"$Fname\", \"$Lname\")";
        mysqli_query($con, $query);
    }
}

function create_artwork($title, $year, $email, $reserve, $con){
    $query = "SELECT artwork_id FROM artwork";
    $result = mysqli_query($con, $query);
    $result = $result->fetch_all();
    $art_ids = array();
    foreach($result as $val){
        array_push($art_ids, $val[0]);
    }

    // Find unique artwork_id
    $unique = False;
    $id = 1;
    while ($unique == False){
        $art_id = "";
        if ($id < 10) $art_id = "A00" . $id;
        elseif ($id < 100) $art_id = "A0" . $id;
        else $art_id = "A" . $id;

        // If unique artwork_id is found, insert into artwork table then create an original
        if (!in_array($art_id, $art_ids)){
            $query = "INSERT INTO artwork VALUES (\"$art_id\", \"$title\", \"$year\", \"$email\", NULL, \"S001\")";
            mysqli_query($con, $query);
            create_original($art_id, $reserve, $con);
            $unique = True;
        }
        else {
            $id = $id + 1;
        }
    }
}

function create_original($art_id, $reserve, $con){
    $cust_id = $_SESSION['customer_id'];
    $query = "INSERT INTO original VALUES (\"$art_id\", \"$cust_id\", $reserve, 0)";
    mysqli_query($con, $query);
}

// Create SQL connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");
if (mysqli_connect_errno()){
    echo "Failed to connect to SQL".mysqli_connect_error();
}

// Validate form input
if (array_key_exists('title', $_POST)){
    $title = test_input($_POST['title']);
    $reserve = test_input($_POST['reserve']);
    $year = test_input($_POST['year']);
    $Fname = test_input($_POST['Fname']);
    $Lname = test_input($_POST['Lname']);
    $email = test_input($_POST['email']);
    
    if (!empty($title) and !empty($reserve) and !empty($year) and !empty($Fname) and !empty($Lname) and !empty($email)){
        create_artist($email, $Fname, $Lname, $con);
        create_artwork($title, $year, $email, $reserve, $con);
        header("Location: submit_artwork.php");
    }
    else {
        echo "Please fill out every field before submitting";
    }
}
?>

</body>
</html>


<style>
    .button_red.current-page  {
        background-color: rgba(170, 170, 170, 0.7);       
    }
</style>