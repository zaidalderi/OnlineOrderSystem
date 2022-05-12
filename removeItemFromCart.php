<?php
    session_start();
    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";
    $cartID = $_SESSION['cartID'];

    $conn  = mysqli_connect($servername, $username, $password, $database);

    if(isset($_GET['itemID'])){
        $itemID = $_GET['itemID'];
        $sql = "DELETE FROM cart_item WHERE cart_item.user_cart_id = ? AND cart_item.item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$cartID,$itemID);
        if($stmt->execute()){
            header("location: cart.php");
        }
    }
    $conn->close();
?>