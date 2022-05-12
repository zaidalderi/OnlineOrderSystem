<?php
    session_start();
    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";

    $conn  = mysqli_connect($servername, $username, $password, $database);
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM user_payment WHERE `user_payment`.`id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        if($stmt->execute()){
            header("location: user_payment_methods.php");
        }
    }
    $conn->close();
?>