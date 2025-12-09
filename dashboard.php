<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Dashboard - IdeateHub</title>
    <link rel="stylesheet" href="theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #7c3aed;
            --accent: #06b6d4;
            --light: #f8fafc;
            --dark: #1e293b;
            --success: #10b981;
            --warning: #f59e0b;
        }
        body { font-family: 'Inter', sans-serif; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1),0 10px 10px -5px rgba(0,0,0,0.04); }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background-color: rgba(37,99,235,0.1); border-left: 4px solid var(--primary); }
        .sidebar-link.active { background-color: rgba(37,99,235,0.1); border-left: 4px solid var(--primary); color: var(--primary); }
        .progress-bar { height:8px; border-radius:4px; background:#e5e7eb; overflow:hidden; }
        .progress-fill { height:100%; border-radius:4px; transition:width 0.5s ease; }
        .rotate-180 { transform: rotate(180deg); }
    </style>
</head>

<body class="bg-gray-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm py-4 sticky top-0 z-10">
        <div class="container mx-auto px-6 flex justify-between items-center">

            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">IdeateHub</span>
            </div>

            <div class="hidden md:flex space-x-8">
                <a href="index.php" class="text-gray-600 hover:text-blue-600 font-medium">Home</a>
                <a href="dashboard.php" class="text-blue-600 font-medium">Dashboard</a>
                <a href="upcoming_feature.php" class="text-gray-600 hover:text-blue-600 font-medium">My Ideas</a>
                <a href="upcoming_feature.php" class="text-gray-600 hover:text-blue-600 font-medium">Teams</a>
            </div>

            <!-- USER DROPDOWN -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button id="userToggle" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <span class="hidden md:inline"><?= htmlspecialchars($user_name); ?></span>
                        <i id="userArrow" class="fas fa-chevron-down text-xs ml-1 transition-all"></i>
                    </button>

                    <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden z-20">
                        <a href="dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-th-large mr-2"></i>Dashboard
                        </a>
                        <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <a href="upcoming_feature.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                        <div class="border-t my-1"></div>
                        <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <!-- MAIN LAYOUT (SIDEBAR + CONTENT) -->
    <div class="flex">

        <!-- SIDEBAR -->
        <div class="w-64 bg-white h-screen shadow-sm p-6 hidden md:block">
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800">Workspace</h2>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($user_name); ?>'s Space</p>
            </div>

            <ul class="space-y-2">
                <li><a href="dashboard.php" class="sidebar-link active flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-th-large w-5"></i><span>Dashboard</span></a></li>
                <li><a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-lightbulb w-5"></i><span>My Ideas</span></a></li>
                <li><a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-users w-5"></i><span>Teams</span></a></li>
                <li><a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-star w-5"></i><span>Favorites</span></a></li>
                <li><a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-chart-bar w-5"></i><span>Analytics</span></a></li>
                <li><a href="profile.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-user w-5"></i><span>Profile</span></a></li>
            </ul>
        </div>


        <!-- MAIN CONTENT -->
        <div class="flex-1 p-6">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-600">Welcome back, <?= htmlspecialchars($user_name); ?>!</p>
            </div>

            <!-- your cards, recent ideas, quick actions etc remain UNCHANGED -->
            <!-- 100% original copied exactly as you provided -->

            <!-- CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Total Ideas</h2>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-blue-600">0</p>
                    <p class="text-sm text-gray-500 mt-2">Start creating ideas</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Collaborators</h2>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-green-600">0</p>
                    <p class="text-sm text-gray-500 mt-2">Invite collaborators</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Points</h2>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-purple-600">0</p>
                    <p class="text-sm text-gray-500 mt-2">Earn points by creating ideas</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Completion Rate</h2>
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tasks text-cyan-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-cyan-600">0%</p>
                    <div class="progress-bar mt-2">
                        <div class="progress-fill bg-cyan-500" style="width: 0%"></div>
                    </div>
                </div>

            </div>

            <!-- RECENT IDEAS + QUICK ACTIONS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6">

                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Recent Ideas</h2>
                            <a href="upcoming_feature.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>New Idea</span>
                            </a>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-lightbulb text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">Eco-Friendly Packaging Solution</h3>
                                    <p class="text-gray-600 text-sm mt-1">Sustainable packaging for e-commerce businesses</p>
                                    <div class="flex items-center mt-3 text-sm text-gray-500">
                                        <span class="flex items-center mr-4">
                                            <i class="far fa-calendar mr-1"></i>
                                            <span>Updated 2 days ago</span>
                                        </span>
                                        <span class="flex items-center">
                                            <i class="far fa-user mr-1"></i>
                                            <span>3 collaborators</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">In Progress</div>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="upcoming_feature.php" class="text-blue-600 hover:text-blue-800 font-medium">View All Ideas <i class="fas fa-arrow-right ml-1"></i></a>
                        </div>

                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="upcoming_feature.php" class="flex items-center space-x-3 p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition duration-200">
                                <i class="fas fa-plus-circle"></i><span>Create New Idea</span>
                            </a>
                            <a href="upcoming_feature.php" class="flex items-center space-x-3 p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition duration-200">
                                <i class="fas fa-user-plus"></i><span>Invite Collaborators</span>
                            </a>
                            <a href="upcoming_feature.php" class="flex items-center space-x-3 p-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition duration-200">
                                <i class="fas fa-chart-line"></i><span>View Analytics</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h2>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-comment text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-gray-800 text-sm">You commented on <span class="font-medium">Eco-Friendly Packaging</span></p>
                                    <p class="text-gray-500 text-xs mt-1">2 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


<!-- ============== JS FOR DROPDOWN ============== -->
<script>
    const toggle = document.getElementById("userToggle");
    const menu = document.getElementById("userMenu");
    const arrow = document.getElementById("userArrow");

    toggle.addEventListener("click", (e) => {
        e.stopPropagation();
        menu.classList.toggle("hidden");
        arrow.classList.toggle("rotate-180");
    });

    document.addEventListener("click", () => {
        if (!menu.classList.contains("hidden")) {
            menu.classList.add("hidden");
            arrow.classList.remove("rotate-180");
        }
    });

    menu.addEventListener("click", (e) => e.stopPropagation());
</script>

</body>
</html>
