<?php
// Start the session (assuming you've already implemented a login system)
session_start();

// Check if the doctor is logged in and their doctor ID is set in the session
if (!isset($_SESSION['doctor_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

// Include the database connection
include('appointment.php');

// Fetch appointments from the database
$sql = "SELECT * FROM appointments ORDER BY date ASC, time ASC";
$result = $conn->query($sql);

// Check if there are any appointments
if ($result->num_rows > 0) {
    $appointments = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // No appointments found
    $appointments = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
    <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
    <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Dashboard</title>
</head>

<body>
    <h1>Welcome to Your Dashboard, Doctor!</h1>
    <h2>Your Appointments</h2>
        <?php if (!empty($appointments)) : ?>
                <h2>Appointments</h2>
                <ul>
                    <?php foreach ($appointments as $appointment) : ?>
                        <li>
                            <strong>Date:</strong> <?php echo $appointment['date']; ?><br>
                            <strong>Time:</strong> <?php echo $appointment['time']; ?><br>
                            <strong>Patient Name:</strong> <?php echo $appointment['patient_name']; ?><br>
                            <strong>Email:</strong> <?php echo $appointment['email']; ?><br>
                            <strong>Phone:</strong> <?php echo $appointment['phone']; ?><br>
                        </li>
                        <br>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No appointments found.</p>
            <?php endif; ?>
        <footer class="footer section gray-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <ul class="list-inline footer-socials mt-4">
                            <li class="list-inline-item"><a href="#"><i class="icofont-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="icofont-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="icofont-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Doctor's login link -->
                    <p class="text-center mb-3">
                        <a href="login.html" class="btn btn-link">Doctor's Login</a>
                </div>

                <div class="col-lg-8 col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <div class="divider mb-4"></div>

                        <ul class="list-unstyled footer-menu lh-35 text-right">
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="appoinment.html">Make Appointment</a></li>
                            <li><a href="diagnosis.html">Diagnosis checker</a></li>
                            <li><a href="service.html">Services</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-btm py-4 mt-5">
                <div class="row">
                    <div class="col-lg-4">
                        <a class="backtop js-scroll-trigger" href="#top">
                            <i class="icofont-long-arrow-up"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="plugins/jquery/jquery.js"></script>
    <script src="plugins/bootstrap/js/popper.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/counterup/jquery.easing.js"></script>
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="plugins/counterup/jquery.waypoints.min.js"></script>
    <script src="plugins/shuffle/shuffle.min.js"></script>
    <script src="plugins/counterup/jquery.counterup.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/contact.js"></script>


</body>

</html>
