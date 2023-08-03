<?php
// Start the session (assuming you've already implemented a login system)
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

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

// Query to fetch all appointments from the appointments table
$sql = "SELECT * FROM appointments";

// Execute the query
$result = $conn->query($sql);

// Check if there are appointments
if ($result->num_rows > 0) {
    // Fetch the data and display the appointments
    while ($row = $result->fetch_assoc()) {
        // Display the appointment information (modify this to match your HTML structure)
        echo "Appointment ID: " . $row["id"] . "<br>";
        echo "Patient Name: " . $row["patient_name"] . "<br>";
        echo "Date: " . $row["date"] . "<br>";
        echo "Time: " . $row["time"] . "<br>";
        echo "Phone: " . $row["phone"] . "<br>";
        echo "<br>";
    }
} else {
    echo "No appointments found.";
}

// Close the database connection
$conn->close();
?>
