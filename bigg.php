<?php
$start = microtime(true);

// Define the CSV file path
$csvFile = "people.csv";

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usersb";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Disable foreign key checks and index updates to speed up insertion
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
mysqli_query($conn, "SET UNIQUE_CHECKS = 0");
mysqli_query($conn, "SET AUTOCOMMIT = 0");
mysqli_query($conn, "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");
mysqli_query($conn, "SET time_zone = '+00:00'");

// Prepare the insert statement
$stmt = mysqli_prepare($conn, "INSERT INTO users (id, user_id, first_name, last_name, sex, email, phone, dob, job_title) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

// Open the CSV file and read the data in batches
$batchSize = 0; // The number of records to insert per batch
if (($handle = fopen($csvFile, "r")) !== FALSE) {
	
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $id = $data[0];
        $user_id = $data[1];
        $first_name = $data[2];
        $last_name = $data[3];
        $sex = $data[4];
        $email = $data[5];
        $phone = $data[6];
        $dob = $data[7];
        $job_title = $data[8];

        mysqli_stmt_bind_param($stmt, "sssssssss", $id, $user_id, $first_name, $last_name, $sex, $email, $phone, $dob, $job_title);
        mysqli_stmt_execute($stmt);
    }

    // Close the CSV file
    fclose($handle);
}

// Commit the transaction and enable foreign key checks and index updates
mysqli_commit($conn);
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
mysqli_query($conn, "SET UNIQUE_CHECKS = 1");
mysqli_query($conn, "SET AUTOCOMMIT = 1");

mysqli_close($conn);

$end = microtime(true);
$executionTime = ($end - $start) * 1000; 
echo "Execution time: " . $executionTime . " ms";


?>