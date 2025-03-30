<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Arenas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-font {
            font-family: "GT Walsheim Medium", "GT Walsheim Medium Placeholder", sans-serif;
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Hero Section -->
<div class="w-full min-h-screen text-left  px-12 pt-16">
    <h1 class="text-[12vw] text-white font-normal custom-font animate-fadeIn">
        Dive into the World's Best Sports Arenas
    </h1>
    <p class="text-3xl text-gray-400 mt-4 custom-font animate-fadeIn delay-200">
        Book and experience sports at legendary venues across the globe.
    </p>
    <div class="mt-8 pt-24 flex justify-center">
        <a href="#arenas-section" class="px-12 py-6 bg-red-500 text-white text-4xl font-normal rounded-full shadow-lg hover:bg-red-600 transition">
            Explore Arenas
        </a>
    </div>
</div>
<!-- Arenas Grid Section -->
<?php
include 'db_connect.php'; // Ensure database connection

// Fetch all arenas from database
$arenaQuery = "SELECT * FROM arenas";
$arenaResult = mysqli_query($conn, $arenaQuery);

if (mysqli_num_rows($arenaResult) > 0): ?>
    <div id="arenas-section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($arena = mysqli_fetch_assoc($arenaResult)): ?>
            <div class="bg-gradient-to-r from-[#1e293b] to-[#334155] p-6 rounded-lg shadow-lg border border-gray-500 hover:shadow-gray-300/80 transition duration-300">
                <img src="<?= htmlspecialchars($arena['image_url']); ?>" alt="<?= htmlspecialchars($arena['name']); ?>" class="w-full h-64 object-cover rounded-2xl">
                <h2 class="text-3xl font-semibold text-white mt-6"><?= htmlspecialchars($arena['name']); ?></h2>
                <p class="text-xl text-gray-400 mt-2"><?= htmlspecialchars($arena['location']); ?></p>
                <p class="text-lg text-gray-300 mt-2"><?= htmlspecialchars($arena['sports']); ?></p>

                <!-- Book Now Button (Automatically generated for each arena) -->
                <a href="booking.php?arena_id=<?= $arena['id']; ?>">
                    <button class="mt-4 block bg-green-500 text-white px-5 py-3 rounded-lg text-lg font-semibold hover:bg-green-600 text-center">
                        Book Now
                    </button>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p class="text-white text-center text-xl font-semibold mt-10">⚠️ No arenas available for booking at the moment.</p>
<?php endif; ?>
    
    
</div>
</body>
</html>