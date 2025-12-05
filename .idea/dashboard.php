<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id   = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
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
        body {
            font-family: 'Inter', sans-serif;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background-color: rgba(37, 99, 235, 0.1);
            border-left: 4px solid var(--primary);
        }
        .sidebar-link.active {
            background-color: rgba(37, 99, 235, 0.1);
            border-left: 4px solid var(--primary);
            color: var(--primary);
        }
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }
    </style>
</head>

<body class="bg-gray-50">
            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>

                        <span class="hidden md:inline">
                            <?= htmlspecialchars($user_name); ?>
                        </span>

                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <!-- Fixed Logout Dropdown -->
                    <div class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden group-hover:block">
                        <div class="py-2">
                            <a href="logout.php" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150 text-sm">
                                <i class="fas fa-sign-out-alt text-gray-400 hover:text-blue-500 mr-3 text-base"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                        </div>

                        <span class="hidden md:inline">
                            <?= htmlspecialchars($user_name); ?>
                        </span>

                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <!-- Elegant Logout Dropdown -->
                    <div class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-xl border border-gray-100 z-50 hidden group-hover:block overflow-hidden">
                        <div class="p-2">
                            <a href="logout.php" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                <div class="w-8 h-8 flex items-center justify-center mr-3">
                                    <i class="fas fa-sign-out-alt text-blue-500"></i>
                                </div>
                                <span class="font-medium">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <div class="w-64 bg-white h-screen shadow-sm p-6 hidden md:block">
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800">Workspace</h2>
                <p class="text-sm text-gray-600">My Personal Space</p>
            </div>
            
            <ul class="space-y-2">
                <li>
                    <a href="dashboard.php" class="sidebar-link active flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                        <i class="fas fa-lightbulb w-5"></i>
                        <span>My Ideas</span>
                    </a>
                </li>
                <li>
                    <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                        <i class="fas fa-users w-5"></i>
                        <span>Teams</span>
                    </a>
                </li>
                <li>
                    <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                        <i class="fas fa-star w-5"></i>
                        <span>Favorites</span>
                    </a>
                </li>
                <li>
                    <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="flex-1 p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-600">Welcome back, <?= htmlspecialchars($user_name); ?>!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Total Ideas</h2>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-blue-600">12</p>
                    <p class="text-sm text-gray-500 mt-2">+2 from last week</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Collaborators</h2>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-green-600">8</p>
                    <p class="text-sm text-gray-500 mt-2">Working with 3 teams</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Points</h2>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-purple-600">1,250</p>
                    <p class="text-sm text-gray-500 mt-2">+150 this month</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Completion Rate</h2>
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tasks text-cyan-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-cyan-600">68%</p>
                    <div class="progress-bar mt-2">
                        <div class="progress-fill bg-cyan-500" style="width: 68%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>