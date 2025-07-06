// Initialize Lucide icons
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});

// Mobile menu toggle
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('active');
    }
}

// Search suggestions (basic implementation)
function initSearchSuggestions() {
    const searchInput = document.querySelector('input[name="word"]');
    if (!searchInput) return;

    const suggestions = [
        'beautiful', 'excellent', 'amazing', 'wonderful', 'brilliant',
        'fantastic', 'incredible', 'outstanding', 'remarkable', 'spectacular',
        'happy', 'sad', 'love', 'good', 'bad', 'big', 'small', 'fast', 'slow'
    ];

    searchInput.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        if (value.length < 2) return;

        const matches = suggestions.filter(word => 
            word.toLowerCase().includes(value)
        ).slice(0, 5);

        // You can implement a dropdown here if needed
        console.log('Suggestions:', matches);
    });
}

// Initialize search suggestions
document.addEventListener('DOMContentLoaded', initSearchSuggestions);

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add loading state to search form
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('form[method="GET"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerHTML = 'Searching...';
                submitButton.disabled = true;
            }
        });
    }
});

// Copy to clipboard functionality
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        showNotification('Copied to clipboard!', 'success');
    }).catch(function() {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showNotification('Copied to clipboard!', 'success');
    });
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('input[name="word"]');
        if (searchInput) {
            searchInput.focus();
        }
    }
});