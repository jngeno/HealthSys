<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

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

    // Prepare and execute the SQL query to select the doctor with the given username
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the doctor exists in the database
    if ($result->num_rows === 1) {
        $doctor = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $doctor['password'])) {
            // Password is correct, doctor is authenticated

            // Redirect to dashboard.html
            header("Location: dashboard.php");
            exit(); // Make sure to exit to prevent further execution of the script

        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "Doctor with the username '$username' does not exist.";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
