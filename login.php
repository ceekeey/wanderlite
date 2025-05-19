<?php
session_start();
require 'config.php';

$message = null;
$messageType = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$email || !$password) {
        $message = "Please fill all fields.";
        $messageType = "error";
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $message = "Login successful! Redirecting...";
                $messageType = "success";
            } else {
                $message = "Incorrect email or password.";
                $messageType = "error";
            }
        } else {
            $message = "Incorrect email or password.";
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

<body class="bg-blue-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-blue-700 text-center mb-6">Welcome Back</h2>

        <form method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email" class="w-full border px-4 py-2 rounded"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
            <input type="password" name="password" placeholder="Password" class="w-full border px-4 py-2 rounded" />
            <button type="submit" name="login"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Login</button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">Don’t have an account? <a href="signup.php"
                class="text-blue-600 hover:underline">Sign Up</a></p>
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
                timerProgressBar: true,
                didClose: () => {
                    <?php if ($messageType === 'success'): ?>
                        window.location.href = 'dashboard.php';
                    <?php endif; ?>
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>