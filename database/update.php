<?php
session_start();
include('database.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $Flavors = $_POST['Flavors'];
    $Sinkers = $_POST['Sinkers'];
    $Sizes = $_POST['Sizes'];
    $Price = $_POST['Price'];

    
    $sql = "UPDATE milktea SET 
            Flavors='$Flavors', 
            Sinkers='$Sinkers', 
            Sizes='$Sizes', 
            Price='$Price' 
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "updated";
    } else {
        $_SESSION['status'] = "error: "; 
    }

    mysqli_close($conn);
    header("Location: ../index.php"); 
    exit();
}
?>
