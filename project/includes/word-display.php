<?php if ($error): ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-red-50 border border-red-200 p-6 rounded-xl">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="h-6 w-6 text-red-600 mr-2"></i>
            <h3 class="text-lg font-semibold text-red-900">Search Error</h3>
        </div>
        <p class="text-red-700 mt-2"><?php echo htmlspecialchars($error); ?></p>
        <div class="mt-4">
            <p class="text-red-600 text-sm">
                Try checking your spelling or searching for a different word. Our system searches across multiple professional dictionaries and thesauruses.
            </p>
        </div>
    </div>
</div>
<?php elseif ($wordData): ?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Word Header -->
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <h1 class="text-4xl font-bold text-gray-900"><?php echo htmlspecialchars($wordData['word']); ?></h1>
                <?php if ($wordData['pronunciation']): ?>
                <div class="flex items-center space-x-2">
                    <span class="text-lg text-gray-600"><?php echo htmlspecialchars($wordData['pronunciation']); ?></span>
                    <button class="p-1 text-blue-600 hover:text-blue-800 transition-colors" title="Pronunciation">
                        <i data-lucide="volume-2" class="h-5 w-5"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <div class="flex items-center space-x-3">
                <?php if ($wordData['difficulty']): ?>
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    <?php 
                    switch($wordData['difficulty']) {
                        case 'easy': echo 'bg-green-100 text-green-800'; break;
                        case 'medium': echo 'bg-yellow-100 text-yellow-800'; break;
                        case 'hard': echo 'bg-red-100 text-red-800'; break;
                        default: echo 'bg-gray-100 text-gray-800';
                    }
                    ?>">
                    <?php echo htmlspecialchars($wordData['difficulty']); ?>
                </span>
                <?php endif; ?>
                <?php if ($wordData['frequency'] > 0): ?>
                <div class="flex items-center space-x-1 text-sm text-gray-600">
                    <i data-lucide="trending-up" class="h-4 w-4"></i>
                    <span>Frequency: <?php echo $wordData['frequency']; ?>%</span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($wordData['partOfSpeech']): ?>
        <div class="mb-6">
            <span class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                <?php echo htmlspecialchars($wordData['partOfSpeech']); ?>
            </span>
        </div>
        <?php endif; ?>
    </div>

    <!-- Definitions -->
    <?php if (!empty($wordData['definitions'])): ?>
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i data-lucide="book-open" class="h-6 w-6 mr-2"></i>
            Definitions
        </h2>
        <div class="space-y-6">
            <?php foreach ($wordData['definitions'] as $index => $def): ?>
            <div class="border-l-4 border-blue-500 pl-6">
                <div class="flex items-start justify-between mb-2">
                    <p class="text-lg text-gray-800 leading-relaxed"><?php echo htmlspecialchars($def['definition']); ?></p>
                    <?php if ($def['partOfSpeech']): ?>
                    <span class="ml-4 bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm font-medium shrink-0">
                        <?php echo htmlspecialchars($def['partOfSpeech']); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php if ($def['example']): ?>
                <p class="text-gray-600 italic mt-2 bg-gray-50 p-3 rounded-lg">
                    "<?php echo htmlspecialchars($def['example']); ?>"
                </p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Synonyms -->
    <?php if (!empty($wordData['synonyms'])): ?>
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i data-lucide="link" class="h-6 w-6 mr-2"></i>
            Synonyms (<?php echo count($wordData['synonyms']); ?>)
        </h2>
        <div class="grid gap-4">
            <?php foreach ($wordData['synonyms'] as $synonym): ?>
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-3">
                    <a href="/?word=<?php echo urlencode($synonym['word']); ?>" 
                       class="text-lg font-medium text-gray-900 hover:text-blue-600 transition-colors">
                        <?php echo htmlspecialchars($synonym['word']); ?>
                    </a>
                    <div class="flex space-x-2">
                        <span class="px-2 py-1 rounded text-xs font-medium 
                            <?php 
                            switch($synonym['strength']) {
                                case 'strong': echo 'bg-blue-100 text-blue-800'; break;
                                case 'moderate': echo 'bg-yellow-100 text-yellow-800'; break;
                                case 'weak': echo 'bg-gray-100 text-gray-800'; break;
                                default: echo 'bg-gray-100 text-gray-800';
                            }
                            ?>">
                            <?php echo htmlspecialchars($synonym['strength']); ?>
                        </span>
                        <span class="px-2 py-1 rounded text-xs font-medium 
                            <?php 
                            switch($synonym['formality']) {
                                case 'formal': echo 'bg-purple-100 text-purple-800'; break;
                                case 'neutral': echo 'bg-gray-100 text-gray-800'; break;
                                case 'informal': echo 'bg-orange-100 text-orange-800'; break;
                                default: echo 'bg-gray-100 text-gray-800';
                            }
                            ?>">
                            <?php echo htmlspecialchars($synonym['formality']); ?>
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <?php if ($synonym['context']): ?>
                    <span class="text-sm text-gray-600 italic"><?php echo htmlspecialchars($synonym['context']); ?></span>
                    <?php endif; ?>
                    <i data-lucide="external-link" class="h-4 w-4 text-gray-400"></i>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Antonyms -->
    <?php if (!empty($wordData['antonyms'])): ?>
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i data-lucide="target" class="h-6 w-6 mr-2"></i>
            Antonyms (<?php echo count($wordData['antonyms']); ?>)
        </h2>
        <div class="flex flex-wrap gap-3">
            <?php foreach ($wordData['antonyms'] as $antonym): ?>
            <a href="/?word=<?php echo urlencode($antonym); ?>" 
               class="px-4 py-2 bg-red-50 text-red-800 rounded-lg font-medium hover:bg-red-100 transition-colors cursor-pointer flex items-center space-x-1">
                <span><?php echo htmlspecialchars($antonym); ?></span>
                <i data-lucide="external-link" class="h-3 w-3"></i>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Data Sources -->
    <div class="bg-gray-50 p-4 rounded-xl">
        <p class="text-sm text-gray-600 text-center">
            Data sourced from Free Dictionary API, Oxford Dictionaries API, Merriam-Webster API, and WordsAPI
        </p>
    </div>
</div>
<?php endif; ?>