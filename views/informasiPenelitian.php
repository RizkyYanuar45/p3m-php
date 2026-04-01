<!DOCTYPE html>

<html lang="id">

<head>

    <title>Informasi Penelitian &amp; Pengabdian | P3M UNIM</title>
    <?php include __DIR__ . '/../helpers/HeadConfig.php';
    require __DIR__ . '/../helpers/Functions.php'
    ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <!-- Top Navigation Bar -->
    <?php include __DIR__ . '/layouts/navbar.php'; ?>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Title Section -->
        <section class="mb-12">
            <div class="relative overflow-hidden rounded-2xl bg-slate-900 px-8 py-12 md:py-16 text-white shadow-xl">
                <div class="absolute inset-0 opacity-20 bg-cover bg-center" data-alt="Abstract library and research collaboration background" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAerTkA5R1m-1KLMqxPnl7T7--Hf_7Elngd1gvwBUIep07ZuK5BYbG-WgDvN_rDb3C07_y2up7B0Lj_aAlIILqS8wL6dXPy-gGAy89b2DKk4Q2LKiyvDU_frp9U7CsDfbGG0dKF7hBgBC039wMqJSgFdm69Cc_iGSbU8rXCTgeEOdWjWWLg3h-XZu-NgDb_8SR7GOyRI9cIThAQnyMmU5xxg9ictvbMb_dCX5baOu0S7zLQJNTWbHLSITbBNf77UL509MVH0D3v8iY');"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/80 to-transparent"></div>
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4">Informasi Penelitian &amp; Pengabdian</h1>
                    <p class="text-slate-300 text-lg md:text-xl font-light">
                        Kumpulan publikasi ilmiah, laporan pengabdian masyarakat, dan inovasi terbaru dari sivitas akademika P3M UNIM.
                    </p>
                </div>
            </div>
        </section>

        <!-- Articles Grid -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (empty($articles)): ?>
                <div class="col-span-full py-20 text-center bg-white dark:bg-slate-900 rounded-2xl border-2 border-dashed border-slate-100 dark:border-slate-800">
                    <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">article</span>
                    <h3 class="text-xl font-bold text-slate-400">Belum ada artikel tersedia</h3>
                    <p class="text-slate-400 mt-2">Informasi penelitian akan segera diperbarui oleh tim P3M.</p>
                </div>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <?php echo render_component('articleCard', $article); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- Pagination -->
        <?php if ($totalPages > 0): ?>
            <div class="mt-16 flex flex-col items-center gap-8">
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Pagination" class="flex items-center gap-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:border-primary hover:text-primary transition-all">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i == 1 || $i == $totalPages || ($i >= $page - 2 && $i <= $page + 2)): ?>
                                <a href="?page=<?= $i ?>" class="w-10 h-10 flex items-center justify-center rounded-lg <?= $i == $page ? 'bg-primary text-white font-bold shadow-sm shadow-orange-200' : 'border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:border-primary hover:text-primary transition-all font-medium' ?>">
                                    <?= $i ?>
                                </a>
                            <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
                                <span class="px-2 text-slate-400">...</span>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:border-primary hover:text-primary transition-all">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>
                <p class="text-sm text-slate-500">Menampilkan <?= count($articles) ?> dari <?= $totalArticles ?> artikel</p>
            </div>
        <?php endif; ?>
    </main>
    <!-- Footer -->
    <?php include __DIR__ . '/layouts/footer.php' ?>
</body>

</html>