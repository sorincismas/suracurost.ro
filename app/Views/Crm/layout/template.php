<!DOCTYPE html>
<html lang="ro" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($page_title ?? 'CRM Pontaj') ?> - suracurost.ro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body class="h-full">
<div class="min-h-full">
    <!-- Meniu Lateral -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
        <div class="flex flex-col flex-grow bg-purple-800 pt-5 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <i class="fa-solid fa-clock text-white text-2xl mr-3"></i>
                <h1 class="text-white text-2xl font-bold">CRM Pontaj</h1>
            </div>
            <div class="mt-5 flex-1 flex flex-col">
                <nav class="flex-1 px-2 pb-4 space-y-1">
                    <a href="<?= site_url('/') ?>" class="text-purple-200 hover:bg-purple-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fa-solid fa-chart-pie mr-3 flex-shrink-0 h-6 w-6 text-purple-300"></i>
                        Dashboard
                    </a>
                    <a href="<?= site_url('angajati') ?>" class="text-purple-200 hover:bg-purple-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fa-solid fa-users mr-3 flex-shrink-0 h-6 w-6 text-purple-300"></i>
                        Angajați
                    </a>
                    <!-- Adauga aici alte linkuri de meniu -->
                </nav>
            </div>
        </div>
    </div>

    <!-- Continut Principal -->
    <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <h1 class="text-3xl font-semibold text-gray-900 mb-6"><?= esc($page_title ?? '') ?></h1>
                </div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <!-- Aici va fi randat continutul specific paginii -->
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
