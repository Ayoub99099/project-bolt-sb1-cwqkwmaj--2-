<?php
session_start();

// Simple admin authentication (enhance for production)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

try {
    $db = new Database();
    $pdo = $db->getConnection();

    // Get statistics
    $stats = [
        'total_users' => 0,
        'premium_users' => 0,
        'total_searches' => 0,
        'searches_today' => 0
    ];

    // Get user stats
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $stats['total_users'] = $stmt->fetch()['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as premium FROM users WHERE subscription_type = 'premium'");
    $stats['premium_users'] = $stmt->fetch()['premium'];

    // Get search stats
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM search_history");
    $stats['total_searches'] = $stmt->fetch()['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as today FROM search_history WHERE DATE(searched_at) = CURDATE()");
    $stats['searches_today'] = $stmt->fetch()['today'];

} catch (Exception $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LexiFind Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">LexiFind Admin Dashboard</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Welcome, Admin</span>
                        <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i data-lucide="users" class="h-6 w-6 text-gray-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                    <dd class="text-lg font-medium text-gray-900"><?php echo number_format($stats['total_users']); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i data-lucide="crown" class="h-6 w-6 text-yellow-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Premium Users</dt>
                                    <dd class="text-lg font-medium text-gray-900"><?php echo number_format($stats['premium_users']); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i data-lucide="search" class="h-6 w-6 text-blue-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Searches</dt>
                                    <dd class="text-lg font-medium text-gray-900"><?php echo number_format($stats['total_searches']); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i data-lucide="trending-up" class="h-6 w-6 text-green-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Searches Today</dt>
                                    <dd class="text-lg font-medium text-gray-900"><?php echo number_format($stats['searches_today']); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="users.php" class="bg-blue-50 p-4 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="flex items-center">
                            <i data-lucide="users" class="h-5 w-5 text-blue-600 mr-2"></i>
                            <span class="text-blue-600 font-medium">Manage Users</span>
                        </div>
                    </a>
                    <a href="analytics.php" class="bg-green-50 p-4 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="flex items-center">
                            <i data-lucide="bar-chart" class="h-5 w-5 text-green-600 mr-2"></i>
                            <span class="text-green-600 font-medium">View Analytics</span>
                        </div>
                    </a>
                    <a href="settings.php" class="bg-purple-50 p-4 rounded-lg hover:bg-purple-100 transition-colors">
                        <div class="flex items-center">
                            <i data-lucide="settings" class="h-5 w-5 text-purple-600 mr-2"></i>
                            <span class="text-purple-600 font-medium">System Settings</span>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>