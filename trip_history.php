<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle trip deletion
if (isset($_GET['delete'])) {
    $trip_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM trips WHERE id=$trip_id AND user_id=$user_id");
    header("Location: trip_history.php");
    exit;
}

$sql = "SELECT * FROM trips WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Budget Travel Planner helps users plan affordable trips with cost estimates and helpful travel tips." />
    <meta name="keywords" content="budget travel, travel planner, trip planning, affordable travel, student project" />
    <meta name="author" content="Your Full Name" />
    <meta name="robots" content="index, follow" />

    <title>Budget Travel Planner | Plan Affordable Trips</title>

    <link rel="canonical" href="https://yourdomain.com/" /> <!-- update when deployed -->

    <meta property="og:title" content="Budget Travel Planner">
    <meta property="og:description" content="Plan affordable trips with estimated costs and travel tips.">
    <meta property="og:image" content="https://yourdomain.com/images/travel-banner.jpg" />
    <meta property="og:url" content="https://yourdomain.com/" />
    <meta name="twitter:card" content="summary_large_image">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-blue-50 min-h-screen p-6">
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow">
        <h2 class="text-2xl font-bold text-blue-700 mb-6">Trip History</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="overflow-x-auto">
                <div class="flex justify-end mb-4">
                    <a href="export_pdf.php"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm">📄 Export to
                        PDF</a>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-100 text-sm">
                            <th class="py-2 px-4 border-b">Destination</th>
                            <th class="py-2 px-4 border-b">Dates</th>
                            <th class="py-2 px-4 border-b">Travelers</th>
                            <th class="py-2 px-4 border-b">Cost</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($trip = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-blue-50 transition text-sm">
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($trip['destination']) ?></td>
                                <td class="py-2 px-4 border-b"><?= $trip['start_date'] ?> to <?= $trip['end_date'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $trip['travelers'] ?></td>
                                <td class="py-2 px-4 border-b">₦<?= number_format($trip['total_cost'], 2) ?></td>
                                <td class="py-2 px-4 border-b flex gap-2">
                                    <button onclick="showDetails(<?= htmlspecialchars(json_encode($trip)) ?>)"
                                        class="text-blue-600 hover:underline">View</button>
                                    <a href="?delete=<?= $trip['id'] ?>" onclick="return confirm('Delete this trip?')"
                                        class="text-red-600 hover:underline">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-600">You have not planned any trips yet.</p>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div id="tripModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md">
            <h3 class="text-xl font-bold text-blue-700 mb-2">Trip Details</h3>
            <div id="modalContent" class="text-sm space-y-2 text-gray-700">
                <!-- Content injected by JS -->
            </div>
            <button onclick="closeModal()"
                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Close</button>
        </div>
    </div>

    <script>
        function showDetails(trip) {
            const modal = document.getElementById('tripModal');
            const content = document.getElementById('modalContent');
            content.innerHTML = `
        <p><strong>Destination:</strong> ${trip.destination}</p>
        <p><strong>Dates:</strong> ${trip.start_date} to ${trip.end_date}</p>
        <p><strong>Travelers:</strong> ${trip.travelers}</p>
        <p><strong>Transport Cost:</strong> ₦${parseFloat(trip.transport_cost).toLocaleString()}</p>
        <p><strong>Hotel Cost:</strong> ₦${parseFloat(trip.hotel_cost).toLocaleString()}</p>
        <p><strong>Food Cost:</strong> ₦${parseFloat(trip.food_cost).toLocaleString()}</p>
        <p><strong>Total:</strong> ₦${parseFloat(trip.total_cost).toLocaleString()}</p>
      `;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('tripModal').classList.add('hidden');
        }
    </script>
</body>

</html>