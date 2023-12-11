<?php

session_start();

if (isset($_SESSION['customer_id'])){
// Create SQL connection
$con = mysqli_connect("localhost", "cpsc471_project", "1234", "art_gallery");

// Check SQL connection
if (!$con) {
    die("Failed to connect to SQL: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="galleryStyle.css">
    <title>Calgary Art Market</title>
</head>

<body>

    <div class="div1">
        
        <button class="button button_home" onclick="location='index.php'">Logout</button>
        <button class="button button_home" onclick="location='index_cust.php'">Home Page</button>
        <h1> Calgary Art Market </h1>
    </div>
    <button class="button_header button_blue" onclick="location='print_collection.php'">Print Collection</button>
    <button class="button_header button_yellow current-page" onclick="location='live_auctions.php'">Live Auctions</button>
    <button class="button_header button_red" onclick="location='submit_artwork.php'">Submit Artwork</button>
    <button class="button_header button_grey" onclick="location='order_history.php'">Order History</button>
    <br><br>    

    <?php
    // AUCTION DISPLAY
    $query = "SELECT * FROM auction";
    $auction = mysqli_query($con, $query);
    
    while ($row = mysqli_fetch_array($auction)) {
        echo '<div class="auction-item">';
        echo '<img src="">';
        echo '<div class="details">';
        echo '<p><strong>Starting Bid:</strong> $' . $row['starting_bid'] . '</p>';
        echo '<p><strong>Highest Bid:</strong> $' . $row['highest_bid'] . '</p>';
        echo '<p><strong>End Date:</strong> ' . $row['end_date'] . '</p>';
        echo '<div class="bid">';
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
        echo '<input type="hidden" name="artwork_id" value="' . $row['artwork_id'] . '">';
        echo '<input type="hidden" name="action" value="submit_bid">';
        echo 'Place Bid: $<input type="text" name="bid_amount">';
        echo '<input type="submit" name="submit_' . $row['artwork_id'] . '" value="Submit Bid">';
        echo '</form>';
    
        if (isset($_POST["submit_" . $row['artwork_id']]) && $_POST['action'] == 'submit_bid') {
            $artwork_id = $_POST["artwork_id"];
            $bid_amount = $_POST["bid_amount"];
    
            // Validate bid amount
            if (!is_numeric($bid_amount) or $bid_amount <= $row['highest_bid'] or $bid_amount <= $row['starting_bid'] ) {
                echo "Invalid bid amount";
            } else {
                $bid_amount = floatval($bid_amount);
    
                $updateQuery = "UPDATE auction SET highest_bid = ? WHERE artwork_id = ?";
                $updateStatement = $con->prepare($updateQuery);
                $updateStatement->bind_param("ds", $bid_amount, $artwork_id);
    
                if ($updateStatement->execute()) {
                    echo "Bid placed successfully!";
                    header("Location: live_auctions.php");
                } else {
                    echo "Error updating bid: " . $updateStatement->error;
                }
    
                $updateStatement->close();
            }
        }
    
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    ?>

    <?php
    mysqli_close($con);
    ?>

</body>

</html>
<?php
}else{
    header("Location: index.php");
    exit();
}
?>


<style>
    .button_yellow.current-page  {
        background-color: rgba(170, 170, 170, 0.7);
        
        
}
    .auction-item {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        max-width: 600px;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(255, 140, 0, 0.2);
    }

    img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    details {
        display: flex;
        flex-direction: column;
    }

    .bid {
        margin-top: 10px;
        display: flex;
    }

    input {
        flex: 1;
        padding: 8px;
        margin-right: 10px;
    }

    button {
        padding: 8px;
        background-color: rgb(41, 120, 173);
        color: #fff;
        border: none;
        cursor: pointer;
    }
</style>
