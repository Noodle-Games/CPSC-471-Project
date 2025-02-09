<?php
session_start();

//Create SQL Connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");

// Check SQL connection
if (mysqli_connect_errno()){
    echo "Failed to connect to SQL".mysqli_connect_error();
}

// Checking user ID
if(isset($_POST['userID'])){
    function test_input($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }

    $userID = test_input($_POST['userID']);
    $userType = test_input($_POST['userType']);

    if(empty($userID)){
        header("Location: index.php?error=User ID Required");
        exit();
    }else if($userType == "customer"){
        // Setting up customer select query
        $sql_user = "SELECT * FROM customer WHERE customer_id='$userID'";
        $result = mysqli_query($con, $sql_user);

        // Fetching relevant data from database
        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if ($row['customer_id'] === $userID){
                $_SESSION['customer_id'] = $row['customer_id'];
                $_SESSION['Fname'] = $row['Fname'];
                $_SESSION['Lname'] = $row['Lname'];
                header("Location: index_cust.php");
                exit();
            }
        }else{
            header("Location: index.php?error=Invalid UserID");
            exit();
        }
    }else if($userType == "employee" and $userID == "E003"){
        // Setting up employee select query
        $sql_user = "SELECT * FROM employee WHERE employee_id='$userID'";
        $result = mysqli_query($con, $sql_user);

        // Fetching relevant data from database
        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if ($row['employee_id'] === $userID){
                $_SESSION['employee_id'] = $row['employee_id'];
                $_SESSION['Fname'] = $row['Fname'];
                $_SESSION['Lname'] = $row['Lname'];
                header("Location: administration.php");
                exit();
            }
        }else{
            header("Location: index.php?error=Invalid UserID");
            exit();
        }
    }else if($userType == "employee"){
        // Setting up employee select query
        $sql_user = "SELECT * FROM employee WHERE employee_id='$userID'";
        $result = mysqli_query($con, $sql_user);

        // Fetching relevant data from database
        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if ($row['employee_id'] === $userID){
                $_SESSION['employee_id'] = $row['employee_id'];
                $_SESSION['Fname'] = $row['Fname'];
                $_SESSION['Lname'] = $row['Lname'];
                header("Location: index_emp.php");
                exit();
            }
        }else{
            header("Location: index.php?error=Invalid UserID");
            exit();
        }
    }else{
        header("Location: index.php");
        exit();
    }
}else{
    header("Location: index.php");
    exit();
}
?>