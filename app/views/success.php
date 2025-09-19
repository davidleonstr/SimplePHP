<?php
require_once __DIR__ . '/../../app/core/Paths.php';
?>

<div class="flex items-center justify-center p-4">
    <div class="rounded-2xl p-8 md:p-12 max-w-md w-full text-center">
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4 animate-pulse">
                <i class="fas fa-check-circle text-3xl text-green-500"></i>
            </div>
        </div>
            
        <!-- Success Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            <span class="text-green-500"><?= $code ?></span>
        </h1>
        <h2 class="text-xl md:text-2xl font-semibold text-gray-700 mb-6">
            <?= $title ?>
        </h2>
            
        <!-- Success Description -->
        <p class="text-gray-600 mb-8 leading-relaxed">
            <?= $message ?>
        </p>
            
        <!-- Action Buttons -->
        <div class="space-y-3 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <!-- Botón principal -->
            <a href="<?= PATHS::$PUBLIC::$URL . $toF ?>" 
                class="inline-flex items-center justify-center w-full md:w-auto px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl group">
                <i class="fas fa-arrow-right mr-2 group-hover:scale-110 transition-transform"></i>
                <span><?= $buttonF ?></span>
            </a>

            <!-- Botón secundario -->
            <a href="<?= PATHS::$PUBLIC::$URL . $toE ?>" 
                class="inline-flex items-center justify-center w-full md:w-auto px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl group">
                <i class="fas fa-arrow-left mr-2 group-hover:scale-110 transition-transform"></i>
                <span><?= $buttonE ?></span>
            </a>
        </div>
            
        <!-- Decorative Elements -->
        <div class="mt-8 opacity-50">
            <div class="flex justify-center space-x-2">
                <div class="w-2 h-2 bg-green-300 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-green-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
        </div>
    </div>
</div>
