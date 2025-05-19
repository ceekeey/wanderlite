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
    <style>
        .fade {
            transition: opacity 1s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-700">Budget Travel Planner</h1>
            <nav>
                <a href="login.php" class="text-blue-700 hover:underline mx-2">Login</a>
                <a href="signup.php" class="text-blue-700 hover:underline mx-2">Sign Up</a>
            </nav>
        </div>
    </header>

    <!-- Slideshow Hero -->
    <section class="relative h-72 md:h-96 overflow-hidden">
        <div class="absolute inset-0">
            <img id="slideImage" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
                class="w-full h-full object-cover fade" />
        </div>
        <div
            class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white text-center">
            <h2 class="text-3xl md:text-5xl font-bold mb-4">Explore the World on a Budget</h2>
            <p class="text-lg md:text-xl mb-6">Plan smart, travel better.</p>
            <a href="signup.php"
                class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-full text-white font-semibold transition">Start
                Planning</a>
        </div>
    </section>

    <!-- Features -->
    <section class="max-w-7xl mx-auto px-4 py-16 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">Cost Estimation</h3>
                <p class="text-gray-600">Get accurate budget calculations for your trips in seconds.</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">Travel Tips</h3>
                <p class="text-gray-600">Receive tips and recommendations tailored to your destination.</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">Trip History</h3>
                <p class="text-gray-600">Easily view and manage your past travel plans.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-blue-50 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-10">What Our Users Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-600">“This app helped me plan my trip to Kenya within my student budget!”</p>
                    <h4 class="mt-4 font-semibold text-blue-700">– Amina, University Student</h4>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-600">“Very easy to use and the travel tips were super useful.”</p>
                    <h4 class="mt-4 font-semibold text-blue-700">– James, Backpacker</h4>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-600">“I used this for my family vacation and saved a lot!”</p>
                    <h4 class="mt-4 font-semibold text-blue-700">– Laura, Mom of 3</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white text-center text-sm text-gray-500 py-6 shadow-inner mt-10">
        &copy; <?php echo date("Y"); ?> Budget Travel Planner. All rights reserved.
    </footer>

    <!-- Slideshow Script -->
    <script>
        const images = [
            "https://images.unsplash.com/photo-1507525428034-b723cf961d3e",
            "https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0",
            "https://images.unsplash.com/photo-1493558103817-58b2924bce98"
        ];
        let index = 0;
        const slideImage = document.getElementById("slideImage");

        setInterval(() => {
            index = (index + 1) % images.length;
            slideImage.style.opacity = 0;
            setTimeout(() => {
                slideImage.src = images[index];
                slideImage.style.opacity = 1;
            }, 500);
        }, 4000);
    </script>
</body>

</html>