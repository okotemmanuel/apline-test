<?php

// Define the CSV file path
$csvFile = "path/to/csv/file.csv";

// Define the number of records and columns
$numRecords = 500000;
$numColumns = 30;

// Define the column names
$columnNames = array();
for ($i = 1; $i <= $numColumns; $i++) {
    $columnNames[] = "col" . $i;
}

// Open the CSV file for writing
$file = fopen($csvFile, 'w');

// Write the column headers to the CSV file
fputcsv($file, $columnNames);

// Generate random data and write it to the CSV file
for ($i = 1; $i <= $numRecords; $i++) {
    $rowData = array();
    for ($j = 1; $j <= $numColumns; $j++) {
        $rowData[] = "data" . rand(1, 100000);
    }
    fputcsv($file, $rowData);
}

// Close the CSV file
fclose($file);

?>