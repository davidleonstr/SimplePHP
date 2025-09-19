<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/core/Paths.php';
require_once __DIR__ . '/../app/core/PathRouter.php';
require_once __DIR__ . '/middleware/CorsMiddleware.php';
require_once __DIR__ . '/../app/helpers/ResponseHelper.php';

// Includes code (reserved position)
require_once __DIR__ . '/../config/headers.php';

// From database.php
global $CONNECTION;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $pdo = $CONNECTION->getConnection();
    
    if ($pdo instanceof PDOException) {
        ResponseHelper::error('Database connection error', 500, $pdo->getMessage());
    }

    CorsMiddleware::handle();

    $router = new PathRouter(PATHS::$API::$PREFIXDISCRIMINATOR);

    // Includes code (reserved position)
    require_once __DIR__ . '/routes/index.php';

    $router->run();

} catch (Exception $e) {
    ResponseHelper::error('Internal Server Error', 500, $e->getMessage());
}