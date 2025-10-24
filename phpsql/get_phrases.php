<?php
header('Content-Type: application/json');
include("config.php");

// Get all phrases from the database
$result = mysqli_query($con, "SELECT * FROM phrases ORDER BY category, english");
$phrases = array();
$translations = array();

// Convert database rows to the required format
while ($row = mysqli_fetch_assoc($result)) {
    // Create the audio path
    $audioPath = 'audio/' . $row['category'] . '/' . str_replace(' ', '_', strtolower($row['english'])) . '.wav';
    
    // Add to phrases array
    $phrases[] = array(
        'key' => $row['english'],
        'path' => '../' . $audioPath
    );
    
    // Add to translations
    $translations[$row['english']] = array(
        'filipino' => $row['filipino'],
        'casiguran_agta' => $row['casiguran_agta']
    );
}

// Return the data in the required format
echo json_encode(array(
    'items' => $phrases,
    'translations' => $translations
));
?>