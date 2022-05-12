<?php
    session_start();
    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";

    $conn  = mysqli_connect($servername, $username, $password, $database);
    $cartID = $_SESSION['cartID'];
    if(isset($_GET['itemID'])){
        $itemID = $_GET['itemID'];
        if(isset($_GET['currentQuantity'])){
            $currentQuanity = $_GET['currentQuantity'];
            if($currentQuanity == 1){
                $sql = "DELETE FROM cart_item WHERE item_id = ? AND user_cart_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii",$itemID,$cartID);
                $stmt->execute();
                header("location:cart.php");
            }else{
                $sql = "UPDATE cart_item SET quantity = quantity - 1 WHERE item_id = ? AND user_cart_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii",$itemID,$cartID);
                $stmt->execute();
                header("location:cart.php");
            }
        }
    }
    $conn->close();
?>

