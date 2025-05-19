<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = null;
$messageType = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $destination = trim($_POST['destination']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $travelers = (int) $_POST['travelers'];
    $transport_cost = (float) $_POST['transport_cost'];
    $hotel_cost = (float) $_POST['hotel_cost'];
    $food_cost = (float) $_POST['food_cost'];

    if (!$destination || !$start_date || !$end_date || $travelers <= 0) {
        $message = "Please fill all required fields correctly.";
        $messageType = "error";
    } elseif ($end_date < $start_date) {
        $message = "End date must be after start date.";
        $messageType = "error";
    } else {
        // Escape inputs
        $destination = mysqli_real_escape_string($conn, $destination);

        $sql = "INSERT INTO trips 
            (user_id, destination, start_date, end_date, travelers, transport_cost, hotel_cost, food_cost) 
            VALUES 
            ($user_id, '$destination', '$start_date', '$end_date', $travelers, $transport_cost, $hotel_cost, $food_cost)";

        if (mysqli_query($conn, $sql)) {
            $message = "Trip planned successfully!";
            $messageType = "success";
        } else {
            $message = "Database error: " . mysqli_error($conn);
            $messageType = "error";
        }
    }
}
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-blue-50 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Plan a New Trip</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="destination" placeholder="Destination" required
                class="w-full border px-4 py-2 rounded" value="<?= htmlspecialchars($_POST['destination'] ?? '') ?>" />
            <div class="flex gap-4">
                <input type="date" name="start_date" required class="flex-1 border px-4 py-2 rounded"
                    value="<?= $_POST['start_date'] ?? '' ?>" />
                <input type="date" name="end_date" required class="flex-1 border px-4 py-2 rounded"
                    value="<?= $_POST['end_date'] ?? '' ?>" />
            </div>
            <input type="number" name="travelers" placeholder="Number of Travelers" min="1" required
                class="w-full border px-4 py-2 rounded" value="<?= htmlspecialchars($_POST['travelers'] ?? '') ?>" />
            <input type="number" name="transport_cost" step="0.01" min="0" placeholder="Transport Cost"
                class="w-full border px-4 py-2 rounded"
                value="<?= htmlspecialchars($_POST['transport_cost'] ?? '0') ?>" />
            <input type="number" name="hotel_cost" step="0.01" min="0" placeholder="Hotel Cost"
                class="w-full border px-4 py-2 rounded" value="<?= htmlspecialchars($_POST['hotel_cost'] ?? '0') ?>" />
            <input type="number" name="food_cost" step="0.01" min="0" placeholder="Food Cost"
                class="w-full border px-4 py-2 rounded" value="<?= htmlspecialchars($_POST['food_cost'] ?? '0') ?>" />
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Plan Trip</button>
        </form>
    </div>

    <?php if ($message): ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: '<?= $messageType ?>',
                title: '<?= addslashes($message) ?>',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                <?php if ($messageType === 'success'): ?>
                                                didClose: () => {
                        window.location.href = 'dashboard.php';
                    }
                                <?php endif; ?>
            });
        </script>
    <?php endif; ?>
</body>

</html>