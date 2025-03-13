<?php
session_start();
include('database.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $Flavors = $_POST['Flavors']; 
    $Sinkers = $_POST['Sinkers']; 
    $Sizes = $_POST['Sizes']; 
    $Price = $_POST['Price']; 

    $sql = "INSERT INTO milktea (Flavors, Sinkers, Sizes, Prices) VALUES ('$Flavors', '$Sinkers', '$Sizes', '$Price')"; 

    if (mysqli_query($conn, $sql)) { 
        $_SESSION['status'] = "created"; 
    } else { 
        $_SESSION['status'] = "error"; 
    }

    mysqli_close($conn); 
    header("Location: ../index.php"); 
    exit(); 
}
?> 