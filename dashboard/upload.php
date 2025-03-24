<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xovis_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST["submit"])) {
    if ($_FILES["csv_file"]["error"] === 0) {
        $filename = $_FILES["csv_file"]["tmp_name"];

        if (($handle = fopen($filename, "r")) !== false) {
            // Skip header row
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                $person_id = $conn->real_escape_string($data[0]);
                $person_type = $conn->real_escape_string($data[1]);
                $entry_time = $conn->real_escape_string(substr($data[2], 0, 23));
                $exit_time = $conn->real_escape_string(substr($data[3], 0, 23));

                $entry_time = str_replace("T", " ", $entry_time);
                $entry_time = str_replace("Z", "", $entry_time);
                $exit_time = str_replace("T", " ", $exit_time);
                $exit_time = str_replace("Z", "", $exit_time);

                $sql = "INSERT INTO people_flow (person_id, person_type, entry_time, exit_time)
                        VALUES ('$person_id', '$person_type', '$entry_time', '$exit_time')";
                $conn->query($sql);
            }

            fclose($handle);
            // Redirect back with success message
            header("Location: index.php?success=1");
            exit;
        }
    }
}
