<div class="max-w-4xl mx-auto">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Discover the Perfect Word
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Explore synonyms, antonyms, definitions, and linguistic relationships with our comprehensive thesaurus powered by multiple professional APIs
        </p>
    </div>

    <!-- Search Form -->
    <form method="GET" action="/" class="relative mb-8">
        <div class="relative">
            <input
                type="text"
                name="word"
                value="<?php echo htmlspecialchars($searchWord); ?>"
                placeholder="Enter a word to explore its meanings and relationships..."
                class="w-full px-6 py-4 pl-12 text-lg border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-lg transition-all duration-200"
                required
            />
            <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-6 w-6 text-gray-400"></i>
            <button
                type="submit"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition-colors font-medium"
            >
                Search
            </button>
        </div>
    </form>

    <!-- Word of the Day -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6 rounded-xl shadow-lg text-white">
            <div class="flex items-center mb-3">
                <i data-lucide="lightbulb" class="h-6 w-6 mr-2"></i>
                <h3 class="text-lg font-semibold">Word of the Day</h3>
            </div>
            <a href="/?word=serendipity" class="text-2xl font-bold hover:underline transition-all duration-200 hover:scale-105">
                serendipity
            </a>
            <p class="text-purple-100 mt-2">
                The occurrence and development of events by chance in a happy or beneficial way
            </p>
        </div>
    </div>

    <!-- Search History and Popular Words -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Search History -->
        <?php if (!empty($_SESSION['search_history'])): ?>
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <div class="flex items-center mb-4">
                <i data-lucide="history" class="h-5 w-5 text-gray-600 mr-2"></i>
                <h3 class="text-lg font-semibold text-gray-900">Recent Searches</h3>
            </div>
            <div class="flex flex-wrap gap-2">
                <?php foreach (array_slice($_SESSION['search_history'], 0, 8) as $historyWord): ?>
                <a href="/?word=<?php echo urlencode($historyWord); ?>" 
                   class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors text-sm flex items-center">
                    <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                    <?php echo htmlspecialchars($historyWord); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Popular Words -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <div class="flex items-center mb-4">
                <i data-lucide="trending-up" class="h-5 w-5 text-gray-600 mr-2"></i>
                <h3 class="text-lg font-semibold text-gray-900">Popular Words</h3>
            </div>
            <div class="flex flex-wrap gap-2">
                <?php 
                $popularWords = ['beautiful', 'excellent', 'amazing', 'wonderful', 'brilliant', 'fantastic', 'incredible', 'outstanding', 'remarkable', 'spectacular'];
                foreach ($popularWords as $word): 
                ?>
                <a href="/?word=<?php echo urlencode($word); ?>" 
                   class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition-colors text-sm font-medium">
                    <?php echo htmlspecialchars($word); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- API Status Indicator -->
    <div class="text-center text-sm text-gray-500">
        <p>Powered by Free Dictionary API, Oxford Dictionaries, Merriam-Webster, and WordsAPI</p>
    </div>
</div>