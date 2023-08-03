<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $patient_name = $_POST["patient_name"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Validate and sanitize the data (implement your validation logic here)
    $formattedDate = date("Y-m-d", strtotime($date));

    // Convert time to MySQL format (HH:MM:SS)
    $formattedTime = date("H:i:s", strtotime($time));

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

    // Prepare and execute the SQL query to insert appointment data into the "appointments" table
    $stmt = $conn->prepare("INSERT INTO appointments (patient_name, date, time, email, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $patient_name, $date, $time, $email, $phone);
    $stmt->execute();

    // Check if the data was successfully inserted
    if ($stmt->affected_rows > 0) {
        // Redirect to the confirmation page
        header("Location: confirmation.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

} else {
    echo "Form not submitted"; // Add this line to check if the form is being submitted
}
?>






