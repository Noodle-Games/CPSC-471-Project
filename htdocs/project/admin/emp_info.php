<?php
session_start();
?>

<html>
<head>
<title> Employee Information </title>
<link rel="stylesheet" href="../galleryStyle.css">
</head>

<body>

<div class="div1">
    
    <button class="button button_home" onclick="location='../index.php'">Logout</button>
    <button class="button button_home" onclick="location='../administration.php'">Home Page</button>
    
    <h1> Calgary Art Market </h1>
    <h2> Employee Information </h2>

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
$emp_id_search = $empErr = "";
// Reference 1: https://www.w3schools.com/php/php_form_complete.asp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(array_key_exists('emp_id_search', $_POST)){
        $emp_id_search = test_input($_POST["emp_id_search"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9' ]*$/",$emp_id_search)) {
            $empErr = "Only letters, numbers, and white space allowed";
        }
    }
}

// SQL query to display artwork
function display_emp($emp_id, $con){
    $query = "";
    if ($emp_id == ""){
        $query = "SELECT * FROM employee";
    }
    else {
        $emp_id = "\"" . $emp_id . "\"";
        $query = "SELECT * FROM employee WHERE employee_id=$emp_id";
    }
    $prints = mysqli_query($con, $query);
    echo "<table border='1'>
    <tr>
    <th class=\"th_blue\"> ID </th>
    <th class=\"th_blue\"> email </th>
    <th class=\"th_blue\"> FName </th>
    <th class=\"th_blue\"> Lname </th>
    <th class=\"th_blue\"> Hourly Wage </th>
    <th class=\"th_blue\"> </th>
    </tr>";
    while($row = mysqli_fetch_array($prints)){
        echo "<tr>";
        echo "<td>" . $row['employee_id']. "</td>";
        echo "<td>" . $row['email']. "</td>";
        echo "<td>" . $row['Fname']. "</td>";
        echo "<td>" . $row['Lname']. "</td>";
        echo "<td>" . $row['hourly_rate']. "</td>";
        echo "<td> <form method=\"post\">  <input style=\"width: 100%;\" type=\"text\" name=\"" . $row['employee_id'] . "\" placeholder=\"Enter Updated Rate\"><br><button style=\"width: 100%;\" type=\"submit\">Update Wage</submit> </form> </td>";
        echo "</tr>";
    }
    echo "</table>";
}

function update_employee($emp_id, $con){

    // Update hourly_wage
    $newQuantity = test_input($_POST[$emp_id]);
    $empid = "\"" . $emp_id . "\"";
    $query = "UPDATE employee SET hourly_rate = $newQuantity WHERE employee_id = $empid";
    mysqli_query($con, $query);
}
?>

<!--Reference 1-->
<!-- Search Employee -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Search Employee by ID: <input type="text" name="emp_id_search" value="<?php echo $emp_id_search;?>">
    <input type="submit" name="submit" value="Search">
    <span> <?php echo $empErr;?></span>
</form>
<!--Reference 1-->

<?php 

// Checking for artwork changes input
$query = "SELECT employee_id FROM employee";
$employee_ids = mysqli_query($con, $query);
while($row = mysqli_fetch_array($employee_ids)){
    if(array_key_exists($row['employee_id'], $_POST)) { 
        $emp_id = $row['employee_id'];
        update_employee($emp_id, $con);
        header("Location: emp_info.php");
    }
}

display_emp($emp_id_search, $con); 

mysqli_close($con);
?>
<!-- END OF MEGA SECTION -->

</body>
</html>