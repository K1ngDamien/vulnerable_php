<?php

// Directory where files will be uploaded
$target_dir = "uploads/";

// Get the file name and target path
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// Check if file was uploaded
if (isset($_POST["submit"])) {
    // Attempt to move the uploaded file to the uploads directory
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        
        // Vulnerable to Command Injection: Executing a shell command with the file name
        echo "<pre>";
        $output = shell_exec("ls -la " . $target_file);
        echo $output;
        echo "</pre>";
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// No file type or size restriction implemented (vulnerability).
