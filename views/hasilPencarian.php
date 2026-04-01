<!DOCTYPE html>

<html class="light" lang="id">

<head>

    <title>Hasil Pencarian - P3M UNIM</title>
    <?php include __DIR__ . "/../helpers/HeadConfig.php" ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display">
    <?php include __DIR__ . "/layouts/navbar.php";
    require __DIR__ . '/../helpers/Functions.php';
    ?>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Hero Section -->
        <section class="mb-12 text-center max-w-4xl mx-auto">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-8 tracking-tight">Eksplorasi Publikasi <span class="text-primary">P3M UNIM</span></h1>

            <form action="/hasil-pencarian" method="GET" class="relative group mb-8">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors text-2xl">search</span>
                </div>
                <input name="q" class="block w-full pl-14 pr-32 py-5 bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm text-lg" placeholder="Masukkan kata kunci judul artikel..." type="text" value="<?= htmlspecialchars($query) ?>" />
                <input type="hidden" name="cat" value="<?= htmlspecialchars($category) ?>">
                <div class="absolute inset-y-2 right-2 flex items-center">
                    <button type="submit" class="bg-primary text-background-dark px-8 h-full rounded-xl font-bold hover:shadow-lg hover:shadow-primary/20 transition-all">Cari Artikel</button>
                </div>
            </form>

            <!-- Category Filters (Functional) -->
            <div class="flex flex-wrap justify-center gap-3 mb-8">
                <?php
                $categories = [
                    'semua' => 'Semua',
                    'informasi_penelitian' => 'Penelitian',
                    'informasi_pengabdian_masyarakat' => 'Pengabdian',
                    'informasi_pengabdian_masyarakat_mandiri' => 'Pengabdian Mandiri',
                    'informasi_kkn' => 'KKN'
                ];
                foreach ($categories as $val => $label):
                    $isActive = ($category === $val);
                    $url = "/hasil-pencarian?q=" . urlencode($query) . "&cat=" . urlencode($val);
                ?>
                    <a href="<?= $url ?>" class="px-5 py-2.5 rounded-full text-sm font-bold transition-all border-2 <?= $isActive ? 'bg-primary border-primary text-background-dark shadow-lg shadow-primary/20' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-primary/50' ?>">
                        <?= $label ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <p class="text-slate-500 dark:text-slate-400 font-medium">
                <?php if ($query !== ''): ?>
                    Menampilkan <span class="text-primary font-bold"><?= $totalResults ?></span> publikasi untuk kata kunci "<span class="italic text-slate-900 dark:text-white"><?= htmlspecialchars($query) ?></span>"
                <?php else: ?>
                    Menampilkan <span class="text-primary font-bold"><?= $totalResults ?></span> publikasi terbaru
                <?php endif; ?>
            </p>
        </section>

        <!-- Dynamic Results Grid (4 Columns) -->
        <?php if (empty($results)): ?>
            <div class="bg-white dark:bg-slate-800 p-20 rounded-3xl border-2 border-dashed border-slate-100 dark:border-slate-700 text-center max-w-2xl mx-auto">
                <div class="size-20 bg-slate-50 dark:bg-slate-700/50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-5xl text-slate-300">find_in_page</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">Data Tidak Ditemukan</h3>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Kami tidak menemukan artikel yang sesuai dengan kriteria Anda. Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="/hasil-pencarian" class="inline-block mt-8 bg-slate-900 dark:bg-slate-700 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-800 transition-all">Reset Pencarian</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                <?php foreach ($results as $news): ?>
                    <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all group border border-slate-100 dark:border-slate-700 flex flex-col h-full">
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="<?= htmlspecialchars($news['thumbnail'] ?: 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=800&auto=format&fit=crop') ?>" />
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-md text-slate-900 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-sm">
                                    <?= str_replace(['informasi_', '_'], ['', ' '], $news['category']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center gap-2 text-[11px] font-bold text-slate-400 mb-4 uppercase tracking-wider">
                                <span class="material-symbols-outlined text-sm text-primary">calendar_today</span>
                                <?= date('d M Y', strtotime($news['published_date'])) ?>
                            </div>
                            <h3 class="text-lg font-bold mb-4 line-clamp-3 group-hover:text-primary transition-colors leading-snug">
                                <?= htmlspecialchars($news['title']) ?>
                            </h3>
                            <div class="mt-auto pt-6 border-t border-slate-50 dark:border-slate-700/50">
                                <a class="w-full bg-slate-50 dark:bg-slate-700/30 text-slate-900 dark:text-white py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-primary hover:text-background-dark transition-all" href="/artikel/<?= urlencode($news['category']) ?>/<?= urlencode($news['slug']) ?>">
                                    Baca Selengkapnya
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Functional Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center items-center gap-3">
                    <?php if ($page > 1): ?>
                        <a href="/hasil-pencarian?q=<?= urlencode($query) ?>&cat=<?= urlencode($category) ?>&page=<?= $page - 1 ?>" class="size-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-background-dark border border-slate-100 dark:border-slate-700 transition-all font-bold group">
                            <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">chevron_left</span>
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i == 1 || $i == $totalPages || ($i >= $page - 2 && $i <= $page + 2)): ?>
                            <a href="/hasil-pencarian?q=<?= urlencode($query) ?>&cat=<?= urlencode($category) ?>&page=<?= $i ?>" class="size-12 rounded-2xl flex items-center justify-center font-black transition-all border <?= $i == $page ? 'bg-primary border-primary text-background-dark shadow-xl shadow-primary/20 scale-110' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-400 hover:border-primary/50' ?>">
                                <?= $i ?>
                            </a>
                        <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
                            <span class="text-slate-400">...</span>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="/hasil-pencarian?q=<?= urlencode($query) ?>&cat=<?= urlencode($category) ?>&page=<?= $page + 1 ?>" class="size-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-background-dark border border-slate-100 dark:border-slate-700 transition-all font-bold group">
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">chevron_right</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>
    <!-- Footer Section -->
    <?php include __DIR__ . "/layouts/footer.php" ?>
</body>

</html>