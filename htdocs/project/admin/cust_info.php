<?php
session_start();
?>

<html>
<head>
<title> Customer Information </title>
<link rel="stylesheet" href="../galleryStyle.css">
</head>

<body>

<div class="div1">
    
    <button class="button button_home" onclick="location='../index.php'">Logout</button>
    <button class="button button_home" onclick="location='../administration.php'">Home Page</button>
    
    <h1> Calgary Art Market </h1>
    <h2> Customer Information </h2>

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
$cust_id_search = $custErr = "";
// Reference 1: https://www.w3schools.com/php/php_form_complete.asp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(array_key_exists('cust_id_search', $_POST)){
        $cust_id_search = test_input($_POST["cust_id_search"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9' ]*$/",$cust_id_search)) {
            $custErr = "Only letters, numbers, and white space allowed";
        }
    }
}

// SQL query to display artwork
function display_cust($cust_id, $con){
    $query = "";
    if ($cust_id == ""){
        $query = "SELECT * FROM customer";
    }
    else {
        $cust_id = "\"" . $cust_id . "\"";
        $query = "SELECT * FROM customer WHERE customer_id=$cust_id";
    }
    $prints = mysqli_query($con, $query);
    echo "<table border='1'>
    <tr>
    <th class=\"th_blue\"> ID </th>
    <th class=\"th_blue\"> email </th>
    <th class=\"th_blue\"> FName </th>
    <th class=\"th_blue\"> Lname </th>
    <th class=\"th_blue\"> </th>
    </tr>";
    while($row = mysqli_fetch_array($prints)){
        echo "<tr>";
        echo "<td>" . $row['customer_id']. "</td>";
        echo "<td>" . $row['email']. "</td>";
        echo "<td>" . $row['Fname']. "</td>";
        echo "<td>" . $row['Lname']. "</td>";
        echo "<td> <form method=\"post\">  <input style=\"width: 100%;\" type=\"text\" name=\"" . $row['customer_id'] . "\" placeholder=\"Enter Updated Email\"><br><button style=\"width: 100%;\" type=\"submit\">Update Email</submit> </form> </td>";
        echo "</tr>";
    }
    echo "</table>";
}

function update_customer($cust_id, $con){

    // Update email
    $newEmail = "\"" . test_input($_POST[$cust_id]) . "\"";
    $custid = "\"" . $cust_id . "\"";
    $query = "UPDATE customer SET email = $newEmail WHERE customer_id = $custid";
    mysqli_query($con, $query);
}
?>

<!--Reference 1-->
<!-- Search customer -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Search customer by ID: <input type="text" name="cust_id_search" value="<?php echo $cust_id_search;?>">
    <input type="submit" name="submit" value="Search">
    <span> <?php echo $custErr;?></span>
</form>
<!--Reference 1-->

<?php 

// Checking for customer changes input
$query = "SELECT customer_id FROM customer";
$customer_ids = mysqli_query($con, $query);
while($row = mysqli_fetch_array($customer_ids)){
    if(array_key_exists($row['customer_id'], $_POST)) { 
        $cust_id = $row['customer_id'];
        update_customer($cust_id, $con);
        header("Location: cust_info.php");
    }
}

display_cust($cust_id_search, $con); 

?>
<!-- END OF MEGA SECTION -->

<h3> Add New Customer </h3>
<!-- Form to enter new exhibiton piece -->
<form method="post">
    <?php if(isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error'];?></p>
    <?php } ?>
    <label>Customer ID</label>
    <input class="input_v" type="text" name="cust_id" placeholder="Enter Customer ID">

    <label>Email</label>
    <input class="input_v" type="text" name="email" placeholder="Enter Email">

    <label>First Name</label>
    <input class="input_v" type="text" name="Fname" placeholder="Enter First Name">

    <label>Last Name</label>
    <input class="input_v" type="text" name="Lname" placeholder="Enter Last Name">
    <input class="input_v" type="submit"></input>
</form>

<?php
function add_cust($cust_id, $email, $Fname, $Lname, $con){
    $query = "SELECT email FROM customer";
    $result = mysqli_query($con, $query);
    $result = $result->fetch_all();
    $cust_ids = array();
    foreach($result as $val){
        array_push($cust_ids, $val[0]);
    }

    if (!in_array($cust_id, $cust_ids)){
        $query = "INSERT INTO customer VALUES (\"$cust_id\", \"$email\", \"$Fname\", \"$Lname\")";
        mysqli_query($con, $query);
    }
}

// Validate form input
if (array_key_exists('cust_id', $_POST)){
    $cust_id = test_input($_POST['cust_id']);
    $email = test_input($_POST['email']);
    $Fname = test_input($_POST['Fname']);
    $Lname = test_input($_POST['Lname']);

    if (!empty($cust_id) and !empty($email) and !empty($Fname) and !empty($Lname)){
        add_cust($cust_id, $email, $Fname, $Lname, $con);
        header("Location: cust_info.php");
    }
    else {
        echo "Please fill out every field before submitting";
    }
}

mysqli_close($con);
?>

</body>
</html>