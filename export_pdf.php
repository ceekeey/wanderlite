<?php
session_start();
require 'config.php';
require 'vendor/autoload.php'; // path to dompdf autoload

use Dompdf\Dompdf;

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM trips WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// Generate HTML content
$html = "<h2 style='text-align: center;'>Trip History - Budget Travel Planner</h2><br>";
$html .= "<table width='100%' border='1' cellspacing='0' cellpadding='5'>
<tr>
    <th>Destination</th>
    <th>Dates</th>
    <th>Travelers</th>
    <th>Total Cost</th>
</tr>";

while ($trip = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
        <td>{$trip['destination']}</td>
        <td>{$trip['start_date']} to {$trip['end_date']}</td>
        <td>{$trip['travelers']}</td>
        <td>₦" . number_format($trip['total_cost'], 2) . "</td>
    </tr>";
}
$html .= "</table>";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("trip_history.pdf", ["Attachment" => true]);
exit;
?>