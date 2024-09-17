<?php
// Simple function to display errors
function show_error($message) {
    echo "<p style='color: red;'>$message</p>";
}

// Check if a command has been entered
$command_output = ''; // Variable to store command output
if (isset($_POST['url'])) {
    // Remote Command Execution vulnerability
    $cmd = $_POST['url'];
    
    // Check if the system is Windows
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // Modify common Unix commands to their Windows equivalents
        if (strpos($cmd, 'ls') !== false) {
            $cmd = str_replace('ls', 'dir', $cmd);
        }
    }
    
    ob_start();
    system($cmd); // Executes the command entered in the form
    $command_output = ob_get_clean(); // Capture the output for displaying on the page
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check your Connection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 50%;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .output {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: left;
            font-family: monospace;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Check your Connection!</h1>
        <p>Provide URL!</p>

        <!-- Form for OS command injection -->
        <form method="POST" action="">
            <input type="text" name="url" placeholder="Enter command (e.g., dir or ipconfig)" value="">
            <br>
            <input type="submit" value="Submit">
        </form>

        <!-- Display command output -->
        <?php if (!empty($command_output)) { ?>
            <div class="output">
                <strong>Status:</strong><br>
                <?php echo htmlspecialchars($command_output); ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
