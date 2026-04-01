<!DOCTYPE html>

<html lang="id">

<head>

    <title>P3M UNIM - <?= htmlspecialchars($article['title']) ?></title>
    <?php include __DIR__ . '/../helpers/HeadConfig.php' ?>

</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="layout-container flex h-full grow flex-col">
        <!-- Header -->
        <?php include __DIR__ . '/layouts/navbar.php' ?>
        <main class="max-w-[1200px] mx-auto w-full px-4 md:px-10 py-6">
            <!-- Breadcrumb -->
            <nav class="flex flex-wrap items-center gap-2 mb-8 text-sm md:text-base">
                <a class="text-slate-500 hover:text-primary transition-colors" href="/">Beranda</a>
                <span class="material-symbols-outlined text-slate-400 text-sm">chevron_right</span>
                <a class="text-slate-500 hover:text-primary transition-colors" href="/<?= htmlspecialchars($article['category']) ?>"><?= htmlspecialchars(ucwords(str_replace('-', ' ', $article['category']))) ?></a>
                <span class="material-symbols-outlined text-slate-400 text-sm">chevron_right</span>
                <span class="text-slate-900 dark:text-slate-100 font-medium truncate max-w-[200px] md:max-w-none"><?= htmlspecialchars($article['title']) ?></span>
            </nav>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Article Main Column -->
                <article class="lg:col-span-8 bg-white dark:bg-slate-900 p-6 md:p-10 rounded-xl shadow-sm">
                    <div class="flex flex-wrap gap-3 mb-6">
                        <a href="/<?= htmlspecialchars($article['category']) ?>" class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider transition-colors hover:bg-primary/20">
                            <?= htmlspecialchars(str_replace('_', ' ', $article['category'])) ?>
                        </a>
                    </div>
                    <h1 class="text-slate-900 dark:text-white text-3xl md:text-4xl font-extrabold leading-tight mb-6">
                        <?= htmlspecialchars($article['title']) ?>
                    </h1>
                    <div class="flex items-center justify-between border-y border-slate-100 dark:border-slate-800 py-6 mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-xl font-bold text-primary ring-2 ring-primary/20">
                                <?= strtoupper(substr($article['author'] ?? 'A', 0, 1)) ?>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-900 dark:text-white text-base font-bold"><?= htmlspecialchars($article['author'] ?? 'Admin') ?></p>
                                <p class="text-slate-500 text-sm">Penulis</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-400 text-xs uppercase tracking-widest font-semibold mb-1">Diterbitkan</p>
                            <p class="text-slate-900 dark:text-slate-300 text-sm font-medium"><?= date('d F Y', strtotime($article['published_date'])) ?></p>
                        </div>
                    </div>
                    <?php if (!empty($article['thumbnail'])): ?>
                        <div class="mb-10 group overflow-hidden rounded-xl">
                            <img alt="<?= htmlspecialchars($article['title']) ?>" class="w-full aspect-video object-cover transition-transform duration-500 group-hover:scale-105" src="<?= htmlspecialchars($article['thumbnail']) ?>" />
                        </div>
                    <?php endif; ?>
                    <!-- Article Body -->
                    <div class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed">
                        <?= nl2br($article['content']) ?>
                    </div>
                    <!-- Share Section -->
                    <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center gap-4">
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Bagikan:</p>
                        <div class="flex gap-2">
                            <button class="size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-[20px]">share</span>
                            </button>
                            <button class="size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-[20px]">content_copy</span>
                            </button>
                        </div>
                    </div>
                </article>
                <!-- Sidebar -->
                <aside class="lg:col-span-4 space-y-8">
                    <!-- Related Articles -->
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm">
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                            <span class="w-1 h-6 bg-primary rounded-full"></span>
                            Artikel Terkait
                        </h4>
                        <div class="space-y-6">
                            <?php if (empty($relatedArticles)): ?>
                                <p class="text-sm text-slate-500 italic">Tidak ada artikel terkait.</p>
                            <?php else: ?>
                                <?php foreach ($relatedArticles as $rel): ?>
                                    <a class="group flex gap-4" href="/artikel/<?= htmlspecialchars($rel['category']) ?>/<?= htmlspecialchars($rel['slug']) ?>">
                                        <div class="shrink-0 size-20 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                            <?php if (!empty($rel['thumbnail'])): ?>
                                                <img alt="<?= htmlspecialchars($rel['title']) ?>" class="w-full h-full object-cover transition-transform group-hover:scale-110" src="<?= htmlspecialchars($rel['thumbnail']) ?>" />
                                            <?php else: ?>
                                                <span class="material-symbols-outlined text-slate-300">image</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h5 class="text-sm font-bold text-slate-900 dark:text-slate-100 leading-snug group-hover:text-primary transition-colors line-clamp-2"><?= htmlspecialchars($rel['title']) ?></h5>
                                            <p class="text-xs text-slate-500 mt-1"><?= date('d M Y', strtotime($rel['published_date'])) ?></p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <a href="/<?= htmlspecialchars($article['category']) ?>" class="block w-full mt-8 py-3 px-4 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-primary/5 hover:border-primary/30 transition-all text-center">Lihat Semua Artikel</a>
                    </div>
                    <!-- Quick Access Links -->
                    <!-- <div class="bg-primary/5 p-6 rounded-xl border border-primary/20">
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Akses Cepat</h4>
                        <ul class="space-y-4">
                            <li>
                                <a class="flex items-center justify-between group text-slate-700 dark:text-slate-300" href="#">
                                    <span class="text-sm font-medium group-hover:text-primary transition-colors">Panduan Penelitian</span>
                                    <span class="material-symbols-outlined text-primary text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center justify-between group text-slate-700 dark:text-slate-300" href="#">
                                    <span class="text-sm font-medium group-hover:text-primary transition-colors">Hibah Pengabdian 2026</span>
                                    <span class="material-symbols-outlined text-primary text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center justify-between group text-slate-700 dark:text-slate-300" href="#">
                                    <span class="text-sm font-medium group-hover:text-primary transition-colors">Template Jurnal</span>
                                    <span class="material-symbols-outlined text-primary text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center justify-between group text-slate-700 dark:text-slate-300" href="#">
                                    <span class="text-sm font-medium group-hover:text-primary transition-colors">Statistik Publikasi</span>
                                    <span class="material-symbols-outlined text-primary text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </li>
                        </ul>
                    </div> -->
                    <!-- Newsletter Sign Up -->

                </aside>
            </div>
        </main>
        <!-- Footer -->
        <?php include __DIR__ . '/layouts/footer.php' ?>
    </div>
</body>

</html>