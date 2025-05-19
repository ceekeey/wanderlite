<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$message = null;
$messageType = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $password = $_POST['password'];
    $updates = [];

    if ($name && $name !== $user['name']) {
        $updates[] = "name = '" . mysqli_real_escape_string($conn, $name) . "'";
        $_SESSION['user_name'] = $name;
    }

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $updates[] = "password = '$hashed'";
    }

    if (!empty($updates)) {
        $sqlUpdate = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = $user_id";
        if (mysqli_query($conn, $sqlUpdate)) {
            $message = "Profile updated successfully!";
            $messageType = "success";
        } else {
            $message = "Something went wrong.";
            $messageType = "error";
        }
    } else {
        $message = "No changes made.";
        $messageType = "info";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Profile Settings</h2>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"
                    class="w-full px-4 py-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" value="<?= htmlspecialchars($user['email']) ?>"
                    class="w-full px-4 py-2 border rounded bg-gray-100" disabled>
            </div>

            <div>
                <label class="block text-sm font-medium">New Password <span
                        class="text-xs text-gray-500">(optional)</span></label>
                <input type="password" name="password" placeholder="Enter new password"
                    class="w-full px-4 py-2 border rounded">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Update
                Profile</button>
        </form>

        <div class="mt-4 text-center">
            <a href="dashboard.php" class="text-sm text-blue-600 hover:underline">← Back to Dashboard</a>
        </div>
    </div>

    <?php if ($message): ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: '<?= $messageType ?>',
                title: '<?= addslashes($message) ?>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    <?php endif; ?>
</body>

</html>