<?php
session_start();

// Initialize search history
if (!isset($_SESSION['search_history'])) {
    $_SESSION['search_history'] = [];
}

// Handle search request
$searchWord = '';
$wordData = null;
$error = null;

if (isset($_GET['word']) && !empty($_GET['word'])) {
    $searchWord = trim($_GET['word']);
    
    // Add to search history
    if (!in_array($searchWord, $_SESSION['search_history'])) {
        array_unshift($_SESSION['search_history'], $searchWord);
        $_SESSION['search_history'] = array_slice($_SESSION['search_history'], 0, 10);
    }
    
    // Fetch word data
    require_once 'includes/ApiService.php';
    $apiService = new ApiService();
    
    try {
        $wordData = $apiService->fetchComprehensiveWordData($searchWord);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$pageTitle = $searchWord ? "LexiFind - " . ucfirst($searchWord) : "LexiFind - Advanced Thesaurus & Dictionary";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="Discover the perfect word with LexiFind's comprehensive thesaurus and dictionary. Explore synonyms, antonyms, definitions, and linguistic relationships.">
    <meta name="keywords" content="thesaurus, dictionary, synonyms, antonyms, word meanings, vocabulary, language, writing tools">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="Discover the perfect word with our comprehensive thesaurus and dictionary platform.">
    <meta property="og:type" content="website">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Search Interface -->
        <?php include 'includes/search-interface.php'; ?>
        
        <!-- Word Display -->
        <?php if ($wordData || $error): ?>
            <?php include 'includes/word-display.php'; ?>
        <?php else: ?>
            <?php include 'includes/welcome-section.php'; ?>
        <?php endif; ?>
    </main>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- JavaScript -->
    <script src="assets/js/app.js"></script>
</body>
</html>