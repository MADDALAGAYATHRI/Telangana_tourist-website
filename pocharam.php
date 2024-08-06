<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email']; // Added email field
$tickets = $_POST['tickets'];
$date = $_POST['date'];
$time = $_POST['time'];

// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO pocharam (name, email, number_of_tickets, date, time) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $name, $email, $tickets, $date, $time); // Updated bind_param to include email

// Execute the statement
if ($stmt->execute()) {
    // Provide download link for PDF
    $pocharam_id = $stmt->insert_id;
    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<p style="font-size: 18px; color: green;">Successfully registered.</p>';
    echo '<a href="downloadpocharam.php?id=' . $pocharam_id . '" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Download Ticket</a>';
    echo '</div>';
} else {
    // Display error message if insertion fails
    echo '<p style="font-size: 18px; color: red; text-align: center;">Error: ' . $stmt->error . '</p>';
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
