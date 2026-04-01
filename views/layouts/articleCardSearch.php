<article class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-100 dark:border-slate-700 hover:shadow-md transition-shadow">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-48 h-32 flex-shrink-0 bg-slate-100 dark:bg-slate-700 rounded-lg overflow-hidden relative">
            <?php if (!empty($thumbnail)): ?>
                <img src="<?= htmlspecialchars($thumbnail) ?>" alt="<?= htmlspecialchars($title) ?>" class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center bg-slate-200 dark:bg-slate-700">
                    <span class="material-symbols-outlined text-4xl text-slate-400">image</span>
                </div>
            <?php endif; ?>
            <span class="absolute top-2 left-2 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider bg-primary">
                <?= htmlspecialchars($category ?? 'Umum') ?>
            </span>
        </div>
        <div class="flex-1">
            <a href="/artikel/<?= urlencode($category ?? 'umum') ?>/<?= urlencode($slug) ?>">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white hover:text-primary transition-colors mb-2 leading-snug">
                    <?= htmlspecialchars($title) ?>
                </h3>
            </a>
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-400 mb-3">
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> <?= htmlspecialchars($author) ?></span>
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> <?= htmlspecialchars($date) ?></span>
            </div>
            <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-2">
                <?= htmlspecialchars($description) ?>
            </p>
        </div>
    </div>
</article>