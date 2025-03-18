<?php
session_start();
include('database.php');

// Check if page number is provided
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Flavors = $_POST['Flavors'];
    $Sinkers = $_POST['Sinkers'];
    $Sizes = $_POST['Sizes'];
    $Price = $_POST['Price'];

    // Sanitize the inputs to avoid SQL injection
    $Flavors = mysqli_real_escape_string($conn, $Flavors);
    $Sinkers = mysqli_real_escape_string($conn, $Sinkers);
    $Sizes = mysqli_real_escape_string($conn, $Sizes);
    $Price = mysqli_real_escape_string($conn, $Price);

    // Prepare the SQL query for insertion
    $sql = "INSERT INTO milktea (Flavors, Sinkers, Sizes, Price) VALUES ('$Flavors', '$Sinkers', '$Sizes', '$Price')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "created";  // Success message
    } else {
        $_SESSION['status'] = "error: " . mysqli_error($conn); // Error message
    }

    // Close the connection
    mysqli_close($conn);

    // Redirect back to the same page
    header("Location: ../index.php?page=$current_page");  // Redirect with current page
    exit();
}
?>
