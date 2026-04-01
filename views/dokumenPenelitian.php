<!DOCTYPE html>

<html lang="id">

<head>

    <title>Dokumen Penelitian P3M UNIM</title>
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
            <span class="text-slate-900 dark:text-slate-100 font-medium">Dokumen Penelitian</span>
        </nav>
        <!-- Hero Section -->
        <div class="mb-10">
            <h2 class="text-4xl font-extrabold tracking-tight mb-2">Dokumen Penelitian</h2>
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
                <div class="bg-white dark:bg-slate-900 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">folder_open</span>
                    <h3 class="text-xl font-bold text-slate-400">Belum ada dokumen tersedia</h3>
                    <p class="text-slate-400 mt-2">Kategori dan dokumen penelitian akan segera diperbarui oleh tim P3M.</p>
                </div>
            <?php else: ?>
                <?php foreach ($categories as $index => $category): ?>
                    <!-- Dynamic Category Item -->
                    <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden" <?= $index === 0 ? 'open' : '' ?>>
                        <summary class="flex items-center justify-between p-5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">
                                        <?php
                                        // Dynamic icons based on category name keywords
                                        $name = strtolower($category['name']);
                                        if (strpos($name, 'panduan') !== false) echo 'science';
                                        elseif (strpos($name, 'pengabdian') !== false) echo 'volunteer_activism';
                                        elseif (strpos($name, 'formulir') !== false || strpos($name, 'administrasi') !== false) echo 'assignment';
                                        elseif (strpos($name, 'template') !== false || strpos($name, 'laporan') !== false) echo 'auto_stories';
                                        elseif (strpos($name, 'kebijakan') !== false || strpos($name, 'sk') !== false) echo 'gavel';
                                        else echo 'folder';
                                        ?>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg"><?= htmlspecialchars($category['name']) ?></h3>
                                    <p class="text-sm text-slate-500">Terdapat <?= count($category['dokumen']) ?> dokumen dalam kategori ini.</p>
                                </div>
                            </div>
                            <span class="material-symbols-outlined transition-transform group-open:rotate-180 text-slate-400">expand_more</span>
                        </summary>
                        <div class="p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/10">
                            <?php if (empty($category['dokumen'])): ?>
                                <p class="text-slate-500 italic text-sm text-center py-4">Tidak ada dokumen tersedia di kategori ini.</p>
                            <?php else: ?>
                                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <?php foreach ($category['dokumen'] as $dok): ?>
                                        <!-- File Item -->
                                        <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-slate-400">
                                                    <?php
                                                    $ext = strtolower(pathinfo($dok['file_name'], PATHINFO_EXTENSION));
                                                    if (in_array($ext, ['pdf'])) echo 'picture_as_pdf';
                                                    elseif (in_array($ext, ['doc', 'docx'])) echo 'description';
                                                    else echo 'draft';
                                                    ?>
                                                </span>
                                                <div>
                                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200"><?= htmlspecialchars($dok['file_name']) ?></h4>
                                                </div>
                                            </div>
                                            <a href="<?= htmlspecialchars($dok['file_url']) ?>" target="_blank" class="bg-primary hover:bg-orange-600 text-white text-sm font-bold px-5 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors w-full sm:w-auto">
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