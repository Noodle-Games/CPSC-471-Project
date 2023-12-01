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
    function validate($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }

    $userID = validate($_POST['userID']);
    $userType = validate($_POST['userType']);

    if(empty($userID)){
        header("Location: loginPage.php?error=User ID Required");
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
                header("Location: index.php");
                exit();
            }
        }else{
            header("Location: loginPage.php?error=Invalid UserID");
            exit();
        }
    }else{
        // Setting up employee select query
        $sql_user = "SELECT * FROM employee WHERE employee_id='$userID'";
        $result = mysqli_query($con, $sql_user);

        // Fetching relevant data from database
        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if ($row['employee_id'] === $userID){
                $_SESSION['employee_id'] = $row['customer_id'];
                $_SESSION['Fname'] = $row['Fname'];
                $_SESSION['Lname'] = $row['Lname'];
                header("Location: index.php");
                exit();
            }
        }else{
            header("Location: loginPage.php?error=Invalid UserID");
            exit();
        }
    }
}else{
    header("Location: loginPage.php");
    exit();
}
