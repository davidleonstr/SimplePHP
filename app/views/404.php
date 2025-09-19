<?php
require_once __DIR__ . '/../../config/config.php';
?>

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="rounded-2xl p-8 md:p-12 max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4 animate-pulse">
                <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
            </div>
        </div>
            
        <!-- Error Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            <span class="text-red-500">404</span>
        </h1>
        <h2 class="text-xl md:text-2xl font-semibold text-gray-700 mb-6">
            Page not found
        </h2>
            
        <!-- Error Description -->
        <p class="text-gray-600 mb-8 leading-relaxed">
            Sorry, the page you're looking for doesn't exist or has been moved.
        </p>
            
        <!-- Action Buttons -->
        <div class="space-y-3 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <a href="<?= PATHS::$PUBLIC::$URL ?>" 
                class="inline-flex items-center justify-center w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl group">
                <i class="fas fa-home mr-2 group-hover:scale-110 transition-transform"></i>
                <span>Return to Home</span>
            </a>
        </div>
            
        <!-- Decorative Elements -->
        <div class="mt-8 opacity-50">
            <div class="flex justify-center space-x-2">
                <div class="w-2 h-2 bg-blue-300 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
        </div>
    </div>
</div>