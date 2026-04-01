<!DOCTYPE html>

<html lang="id">

<head>

    <title>Dokumen P3M UNIM</title>
    <?php include __DIR__ . '/../helpers/HeadConfig.php' ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        details>summary {
            list-style: none;
        }

        details>summary::-webkit-details-marker {
            display: none;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <!-- Top Navigation Bar -->
    <?php include __DIR__ . "/layouts/navbar.php" ?>
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-8">
            <a class="hover:text-primary" href="#">Beranda</a>
            <span class="material-symbols-outlined text-base">chevron_right</span>
            <span class="text-slate-900 dark:text-slate-100 font-medium">Dokumen P3M</span>
        </nav>
        <!-- Hero Section -->
        <div class="mb-10">
            <h2 class="text-4xl font-extrabold tracking-tight mb-2">Dokumen P3M</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400">Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Universitas Islam Majapahit</p>
        </div>
        <!-- Search & Filter Controls -->
        <!-- <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full pl-12 pr-4 py-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-base focus:ring-primary focus:border-primary shadow-sm" placeholder="Ketik kata kunci dokumen atau panduan yang Anda cari..." type="text" />
            </div>
            <button class="bg-primary hover:bg-orange-600 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">filter_list</span>
                Filter
            </button>
        </div> -->
        <!-- Document Repository Accordion -->
        <div class="space-y-4">
            <?php if (empty($categories)): ?>
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-10 text-center">
                    <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">folder_off</span>
                    <h3 class="text-xl font-bold text-slate-500">Belum ada dokumen tersedia</h3>
                    <p class="text-slate-400 text-sm mt-2">Silakan periksa kembali nanti atau hubungi unit terkait.</p>
                </div>
            <?php else: ?>
                <?php foreach ($categories as $index => $cat): ?>
                    <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden" <?= $index === 0 ? 'open' : '' ?>>
                        <summary class="flex items-center justify-between p-5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">folder</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg"><?= htmlspecialchars($cat['name']) ?></h3>
                                    <p class="text-sm text-slate-500">Kumpulan dokumen dan panduan untuk kategori <?= htmlspecialchars($cat['name']) ?>.</p>
                                </div>
                            </div>
                            <span class="material-symbols-outlined transition-transform group-open:rotate-180 text-slate-400">expand_more</span>
                        </summary>
                        <div class="p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/10">
                            <?php if (empty($cat['dokumen'])): ?>
                                <p class="text-slate-500 italic text-sm text-center py-4">Tidak ada dokumen tersedia di kategori ini.</p>
                            <?php else: ?>
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <?php foreach ($cat['dokumen'] as $dok): ?>
                                        <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="flex items-center gap-3">
                                                <div class="size-8 bg-slate-100 dark:bg-slate-800 rounded flex items-center justify-center text-slate-400">
                                                    <span class="material-symbols-outlined text-sm">description</span>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200"><?= htmlspecialchars($dok['file_name']) ?></h4>
                                                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold"><?= strtoupper(pathinfo($dok['file_name'], PATHINFO_EXTENSION)) ?> DOCUMENT</p>
                                                </div>
                                            </div>
                                            <a href="<?= htmlspecialchars($dok['file_url']) ?>" target="_blank" class="bg-primary hover:bg-orange-600 text-white text-sm font-bold px-5 py-2.5 rounded-lg flex items-center justify-center gap-2 transition-all w-full sm:w-auto hover:shadow-lg hover:shadow-primary/20">
                                                <span class="material-symbols-outlined text-base">download</span>
                                                Unduh
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </details>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
    <!-- Footer Footer -->

    <?php include __DIR__ . "/layouts/footer.php" ?>
</body>

</html>