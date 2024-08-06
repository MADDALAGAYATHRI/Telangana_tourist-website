<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['id'])) {
    // Retrieve reservation ID from URL parameter
    $pocharam_id = $_GET['id'];

    // Prepare SQL statement to fetch reservation details
    $stmt = $conn->prepare("SELECT * FROM pocharam WHERE id = ?");
    $stmt->bind_param("i", $pocharam_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if reservation exists
    if ($result->num_rows > 0) {
        // Fetch reservation details
        $row = $result->fetch_assoc();
        
        // Generate PDF content
        require_once('tcpdf/tcpdf.php');
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Reservation Details', 0, 1, 'C');
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Ticket ID: ' . $row['id'], 0, 1);
        $pdf->Cell(0, 10, 'Name: ' . $row['name'], 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $row['email'], 0, 1); // Display Email
        $pdf->Cell(0, 10, 'Number of Tickets: ' . $row['number_of_tickets'], 0, 1);
        $pdf->Cell(0, 10, 'Date: ' . $row['date'], 0, 1);
        $pdf->Cell(0, 10, 'Time: ' . $row['time'], 0, 1);
        
        // Output PDF as download
        $pdf->Output('reservation_ticket.pdf', 'D');
    } else {
        echo "Reservation not found.";
    }
}

// Close connection
$conn->close();
?>
