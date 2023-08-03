<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate and sanitize the data (implement your validation logic here)

    // Connect to the MySQL database
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "health";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare and execute the SQL query to insert user data into the "users" table
    $stmt = $conn->prepare("INSERT INTO doctors (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    $stmt->execute();
    
    // Check if the data was successfully inserted
    if ($stmt->affected_rows > 0) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    if ($stmt->affected_rows > 0) {
        // Redirect to the login page after successful registration
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
