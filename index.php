<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeateHub - Business Idea Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/theme.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    
    <nav class="bg-white shadow-sm py-4 sticky top-0 z-10">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">IdeateHub</span>
            </div>
            
            <div class="hidden md:flex space-x-8">
                <a href="pages/register.php" class="text-gray-600 hover:text-blue-600 font-medium">Features</a>
                <a href="pages/subscription.php" class="text-gray-600 hover:text-blue-600 font-medium">Pricing</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="pages/login.php" class="text-gray-600 hover:text-blue-600 font-medium hidden md:block">Log in</a>
                <a href="pages/register.php" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium transition duration-300">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <section class="gradient-bg text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6" data-aos="fade-down">Turn Ideas Into Reality</h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto opacity-90" data-aos="fade-up" data-aos-delay="200">
                Collaborate, organize, and bring your business ideas to life with our powerful platform designed for innovators.
            </p>
            <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-6" data-aos="fade-up" data-aos-delay="400">
                <a href="<?php echo isset($_SESSION['user_id']) ? 'pages/idea_wizard.php' : 'pages/register.php'; ?>" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 shadow-lg">
                    Create Your First Idea
                </a>
                
                <a href="<?php echo isset($_SESSION['user_id']) ? 'pages/dashboard.php' : 'pages/login.php'; ?>" 
                   class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold 
                          hover:bg-white hover:text-blue-600 transition duration-300">
                    Explore Dashboard
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Powerful Features for Idea Management</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Everything you need to organize, develop, and execute your business ideas effectively.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-gray-50 p-8 rounded-xl card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon bg-blue-100 text-blue-600">
                        <i class="fas fa-brain text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Idea Organization</h3>
                    <p class="text-gray-600 mb-4">Categorize and prioritize your ideas with customizable boards, lists, and cards.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Visual organization
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Custom workflows
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Progress tracking
                        </li>
                    </ul>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon bg-purple-100 text-purple-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Team Collaboration</h3>
                    <p class="text-gray-600 mb-4">Invite team members, assign tasks, and work together seamlessly in real-time.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Real-time updates
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Comment threads
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            File sharing
                        </li>
                    </ul>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon bg-cyan-100 text-cyan-600">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Progress Analytics</h3>
                    <p class="text-gray-600 mb-4">Track your idea development with detailed analytics and progress reports.</p>
                    <ul class="text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Progress dashboards
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Performance metrics
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Success prediction
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">How IdeateHub Works</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Simple steps to transform your ideas into successful business ventures.</p>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
                    <div class="relative">
                        <div class="bg-white p-8 rounded-xl shadow-lg">
                            <div class="flex items-start mb-6">
                                <div class="bg-blue-100 text-blue-600 rounded-full w-10 h-10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="font-bold">1</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Capture Your Idea</h3>
                                    <p class="text-gray-600">Quickly jot down your business concept with our intuitive idea capture tool.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start mb-6">
                                <div class="bg-purple-100 text-purple-600 rounded-full w-10 h-10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="font-bold">2</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Organize & Develop</h3>
                                    <p class="text-gray-600">Break down your idea into actionable steps and organize them visually.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-green-100 text-green-600 rounded-full w-10 h-10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="font-bold">3</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Collaborate & Execute</h3>
                                    <p class="text-gray-600">Invite team members, assign tasks, and track progress toward implementation.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-2/5" data-aos="fade-left" data-aos-delay="200">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 text-white">
                            <h3 class="text-xl font-bold">Sample Idea Board</h3>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">To Do</h4>
                                <div class="bg-blue-50 p-3 rounded-lg mb-2">
                                    <p class="text-gray-800 font-medium">Market Research</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-600">
                                        <i class="far fa-calendar mr-1"></i>
                                        <span>Due: Tomorrow</span>
                                    </div>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <p class="text-gray-800 font-medium">Competitor Analysis</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-600">
                                        <i class="far fa-user mr-1"></i>
                                        <span>Assigned: You</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">In Progress</h4>
                                <div class="bg-yellow-50 p-3 rounded-lg">
                                    <p class="text-gray-800 font-medium">Prototype Development</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-600">
                                        <i class="far fa-clock mr-1"></i>
                                        <span>65% complete</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Completed</h4>
                                <div class="bg-green-50 p-3 rounded-lg">
                                    <p class="text-gray-800 font-medium">Idea Validation</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-600">
                                        <i class="far fa-check-circle mr-1 text-green-500"></i>
                                        <span>Completed: Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Trusted by Innovators Worldwide</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">See how teams are using IdeateHub to bring their ideas to life.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold mr-4">
                            SJ
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Sarah Johnson</h4>
                            <p class="text-gray-600 text-sm">Startup Founder</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "IdeateHub transformed how our team collaborates on new business ideas. We've launched 3 successful ventures in the past year thanks to this platform."
                    </p>
                    <div class="flex text-yellow-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold mr-4">
                            MR
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Michael Rodriguez</h4>
                            <p class="text-gray-600 text-sm">Product Manager</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "The visual organization and progress tracking features have made our innovation process 40% more efficient. Highly recommended for any product team."
                    </p>
                    <div class="flex text-yellow-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-4">
                            AL
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Amanda Lee</h4>
                            <p class="text-gray-600 text-sm">Innovation Director</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "We've tried many idea management tools, but IdeateHub stands out with its intuitive interface and powerful collaboration features. It's a game-changer."
                    </p>
                    <div class="flex text-yellow-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 gradient-bg text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6" data-aos="zoom-in">Ready to Bring Your Ideas to Life?</h2>
            <p class="text-xl mb-10 max-w-2xl mx-auto opacity-90" data-aos="zoom-in" data-aos-delay="200">
                Join thousands of innovators already using IdeateHub to turn their ideas into successful businesses.
            </p>
            <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-6" data-aos="zoom-in" data-aos-delay="400">
                <a href="<?php echo isset($_SESSION['user_id']) ? 'pages/idea_wizard.php' : 'pages/register.php'; ?>" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 shadow-lg">
                    Start Free Trial
                </a>
                <a href="pages/subscription.php" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                    View Pricing
                </a>
            </div>
            <p class="mt-6 text-sm opacity-80">No credit card required. Free 14-day trial.</p>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-white"></i>
                        </div>
                        <span class="text-xl font-bold">IdeateHub</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        The ultimate platform for business idea management and collaboration.
                    </p>
                    <div class="flex space-x-4">
                        <a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Product</h3>
                    <ul class="space-y-2">
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Features</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Solutions</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Pricing</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Templates</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">User Guides</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Webinars</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Community</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Careers</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="pages/upcoming_feature.php" class="text-gray-400 hover:text-white">Partners</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 IdeateHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 800, 
        once: true,    
      });
    </script>
</body>
</html>
