<header class="bg-white shadow-lg border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <i data-lucide="book" class="h-6 w-6 text-white"></i>
                </div>
                <div>
                    <a href="/" class="text-2xl font-bold text-gray-900 hover:text-blue-600 transition-colors">LexiFind</a>
                    <p class="text-sm text-gray-600">Advanced Thesaurus & Dictionary</p>
                </div>
            </div>
            
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">Home</a>
                <a href="/about.php" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">About</a>
                <a href="/api.php" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">API</a>
                <a href="/premium.php" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">Premium</a>
                <a href="/contact.php" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">Contact</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="/login.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Sign In
                </a>
                <button class="md:hidden" onclick="toggleMobileMenu()">
                    <i data-lucide="menu" class="h-6 w-6 text-gray-700"></i>
                </button>
            </div>
        </div>
    </div>
</header>