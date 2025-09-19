<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'No title') ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="/ASGT/public/src/css/output.css">
    <link rel="stylesheet" href="/ASGT/public/src/css/fontawesome-free-7.0.0-web/css/all.min.css">
    <link rel="stylesheet" href="/ASGT/public/src/js/toastify-js-master/src/toastify.css">

    <!-- JS -->
    <script src="/ASGT/public/src/js/toastify-js-master/src/toastify.js"></script>
    <script src="/ASGT/public/src/js/main.js"></script>
    
    <!-- Meta tags -->
    <meta name="description" content="Sistema de Gestión Territorial">
    <meta name="author" content="INCAS">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="/ASGT/public/src/css/main.css">
</head>
<body>
    <!-- Main Content -->
    <main class="main-content overflow-x-hidden">
        <?= $content ?>
    </main>
</body>
</html>
