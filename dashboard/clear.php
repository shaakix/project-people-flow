<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xovis_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear all records from the people_flow table
$sql = "DELETE FROM people_flow";

if ($conn->query($sql) === TRUE) {
    echo "All records deleted successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

// Redirect back to upload page
header("Location: index.php");
exit;
?>
