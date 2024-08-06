<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $totalTickets = $_POST["tickets"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $freeTickets = isset($_POST["free_tickets"]) ? $_POST["free_tickets"] : 0;
    $vipDarshan = isset($_POST["vip_darshan"]) ? $_POST["vip_darshan"] : 0;

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO yadagiri (name, email, tickets, date, time, free_tickets, vip_darshan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssi", $name, $email, $totalTickets, $date, $time, $freeTickets, $vipDarshan);
    
    // Execute SQL statement
    if ($stmt->execute()) {
        echo "<h1>Registration Successful!</h1>";
        echo "<p>Your reservation has been successfully registered.</p>";
        
        // Get the ID of the last inserted row
        $yadagiri_id = $stmt->insert_id;

        // Output the download ticket link
        echo '<a href="downloadyadagiri.php?id=' . $yadagiri_id . '" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Download Ticket</a>';
    } else {
        // Display error message if insertion fails
        echo "<h1>Registration Failed</h1>";
        echo "<p>There was an error processing your reservation. Please try again later.</p>";
        echo '<p style="font-size: 18px; color: red; text-align: center;">Error: ' . $stmt->error . '</p>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>