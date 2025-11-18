<?php // dashboard.php ?>
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

    <!-- Navigation -->
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
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <span class="hidden md:inline">John Doe</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
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
            
            <div class="mt-10">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Teams</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                            <div class="w-6 h-6 bg-blue-100 rounded flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xs"></i>
                            </div>
                            <span>Marketing Team</span>
                        </a>
                    </li>
                    <li>
                        <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                            <div class="w-6 h-6 bg-green-100 rounded flex items-center justify-center">
                                <i class="fas fa-users text-green-600 text-xs"></i>
                            </div>
                            <span>Product Team</span>
                        </a>
                    </li>
                    <li>
                        <a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700">
                            <div class="w-6 h-6 bg-purple-100 rounded flex items-center justify-center">
                                <i class="fas fa-users text-purple-600 text-xs"></i>
                            </div>
                            <span>Innovation Lab</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-600">Welcome back! Here's an overview of your ideas and progress.</p>
            </div>

            <!-- Stats Cards -->
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

            <!-- Recent Activity & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Ideas -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Recent Ideas</h2>
                            <a href="create_idea.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
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
                                <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                    In Progress
                                </div>
                            </div>
                            
                            <div class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-lightbulb text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">AI-Powered Customer Support</h3>
                                    <p class="text-gray-600 text-sm mt-1">Automated support system with machine learning</p>
                                    <div class="flex items-center mt-3 text-sm text-gray-500">
                                        <span class="flex items-center mr-4">
                                            <i class="far fa-calendar mr-1"></i>
                                            <span>Updated 1 week ago</span>
                                        </span>
                                        <span class="flex items-center">
                                            <i class="far fa-user mr-1"></i>
                                            <span>5 collaborators</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                    Research
                                </div>
                            </div>
                            
                            <div class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-lightbulb text-purple-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">Remote Team Collaboration Tool</h3>
                                    <p class="text-gray-600 text-sm mt-1">Platform for distributed teams to collaborate effectively</p>
                                    <div class="flex items-center mt-3 text-sm text-gray-500">
                                        <span class="flex items-center mr-4">
                                            <i class="far fa-calendar mr-1"></i>
                                            <span>Updated 3 weeks ago</span>
                                        </span>
                                        <span class="flex items-center">
                                            <i class="far fa-user mr-1"></i>
                                            <span>2 collaborators</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                                    Planning
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="upcoming_feature.php" class="text-blue-600 hover:text-blue-800 font-medium">
                                View All Ideas <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions & Activity -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="create_idea.php" class="flex items-center space-x-3 p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition duration-200">
                                <i class="fas fa-plus-circle"></i>
                                <span>Create New Idea</span>
                            </a>
                            <a href="upcoming_feature.php" class="flex items-center space-x-3 p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition duration-200">
                                <i class="fas fa-user-plus"></i>
                                <span>Invite Collaborators</span>
                            </a>
                            <a href="upcoming_feature.php" class="flex items-center space-x-3 p-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition duration-200">
                                <i class="fas fa-chart-line"></i>
                                <span>View Analytics</span>
                            </a>
                            <a href="upcoming_feature.php" class="flex items-center space-x-3 p-3 bg-cyan-50 text-cyan-700 rounded-lg hover:bg-cyan-100 transition duration-200">
                                <i class="fas fa-download"></i>
                                <span>Export Ideas</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
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
                            
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-user-plus text-green-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-gray-800 text-sm">You added <span class="font-medium">Sarah</span> to <span class="font-medium">AI Customer Support</span></p>
                                    <p class="text-gray-500 text-xs mt-1">Yesterday</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-lightbulb text-purple-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-gray-800 text-sm">You created <span class="font-medium">Remote Team Tool</span></p>
                                    <p class="text-gray-500 text-xs mt-1">3 days ago</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-tasks text-yellow-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-gray-800 text-sm">You completed <span class="font-medium">Market Research</span> for <span class="font-medium">AI Customer Support</span></p>
                                    <p class="text-gray-500 text-xs mt-1">1 week ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>