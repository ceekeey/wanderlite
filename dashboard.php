<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$costData = [];
$labels = [];

$resChart = mysqli_query($conn, "SELECT destination, total_cost FROM trips WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($resChart)) {
    $labels[] = $row['destination'];
    $costData[] = $row['total_cost'];
}

// Fetch total trips
$res1 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM trips WHERE user_id = $user_id");
$totalTrips = mysqli_fetch_assoc($res1)['total'] ?? 0;

// Fetch total cost
$res2 = mysqli_query($conn, "SELECT SUM(total_cost) AS cost FROM trips WHERE user_id = $user_id");
$totalCost = mysqli_fetch_assoc($res2)['cost'] ?? 0;

// Fetch total unique destinations
$res3 = mysqli_query($conn, "SELECT COUNT(DISTINCT destination) AS places FROM trips WHERE user_id = $user_id");
$totalPlaces = mysqli_fetch_assoc($res3)['places'] ?? 0;
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Layout -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed md:static top-0 left-0 h-full w-64 bg-gradient-to-b from-blue-800 to-blue-600 text-white shadow-md transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
            <div class="p-6 text-2xl font-bold tracking-wide flex justify-between items-center">
                ✈️ Travel Planner
                <button onclick="toggleSidebar()" class="md:hidden text-white text-2xl">&times;</button>
            </div>
            <nav class="space-y-2 mt-6 px-4 text-sm font-medium">
                <a href="#overview" class="block px-4 py-2 rounded hover:bg-blue-500">🏠 Dashboard</a>
                <a href="plan_trip.php" class="block px-4 py-2 rounded hover:bg-blue-500">🧳 Plan Trip</a>
                <a href="#tips" class="block px-4 py-2 rounded hover:bg-blue-500">💡 Travel Tips</a>
                <a href="trip_history.php" class="block px-4 py-2 rounded hover:bg-blue-500">📜 Trip History</a>
                <a href="profile.php" class="block px-4 py-2 rounded hover:bg-blue-500">👤 Profile</a>
                <a href="logout.php" class="block px-4 py-2 rounded mt-6 bg-red-500 hover:bg-red-600">🚪 Logout</a>
                <a href="#history" class="block px-4 py-2 rounded hover:bg-blue-500"></a>
                <a href="#history" class="block px-4 py-2 rounded hover:bg-blue-500"></a>
                <a href="#history" class="block px-4 py-2 rounded hover:bg-blue-500"></a>
                <a href="#history" class="block px-4 py-2 rounded hover:bg-blue-500"></a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">

            <!-- Top Bar -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center sticky top-0 z-40">
                <h1 class="text-xl font-semibold text-blue-700">Welcome, <span
                        class="font-bold"><?= htmlspecialchars($_SESSION['user_name']) ?></span></h1>
                <button onclick="toggleSidebar()" class="md:hidden text-blue-700 text-2xl">☰</button>
            </header>

            <!-- Page Content -->
            <main class="p-6 space-y-10">

                <!-- Overview Stats -->
                <section id="overview">
                    <h2 class="text-2xl font-bold text-blue-800 mb-4">📊 Overview</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                            <p class="text-gray-500">Total Trips</p>
                            <h3 class="text-3xl font-bold text-blue-700"><?= $totalTrips ?></h3>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                            <p class="text-gray-500">Total Destination</p>
                            <h3 class="text-3xl font-bold text-blue-700"><?= $totalPlaces ?></h3>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                            <p class="text-gray-500">Estimated Cost</p>
                            <h3 class="text-3xl font-bold text-blue-700">₦<?= number_format($totalCost, 2) ?></h3>
                        </div>

                        <?php
                        $recentTrip = mysqli_query($conn, "SELECT * FROM trips WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 1");
                        $trip = mysqli_fetch_assoc($recentTrip);
                        ?>
                        <?php if ($trip): ?>
                            <div class="bg-white shadow rounded-lg p-6 mt-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">📍 Most Recent Trip</h3>
                                <p><strong>Destination:</strong> <?= htmlspecialchars($trip['destination']) ?></p>
                                <p><strong>Travel Dates:</strong> <?= htmlspecialchars($trip['start_date']) ?> to
                                    <?= htmlspecialchars($trip['end_date']) ?>
                                </p>
                                <p><strong>Total Travelers:</strong> <?= $trip['travelers'] ?></p>
                                <p><strong>Estimated Cost:</strong> ₦<?= number_format($trip['total_cost'], 2) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <div class="bg-white shadow rounded-lg p-6 mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">📊 Cost by Destination</h3>
                    <canvas id="tripChart" height="100"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('tripChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode($labels) ?>,
                            datasets: [{
                                label: 'Estimated Cost (₦)',
                                data: <?= json_encode($costData) ?>,
                                backgroundColor: '#3b82f6'
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function (value) {
                                            return '₦' + value.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </main>

        </div>
    </div>


    <!-- JS -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("-translate-x-full");
        }
    </script>
</body>

</html>