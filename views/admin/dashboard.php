<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <?php include __DIR__ . '/../../helpers/HeadConfig.php'; ?>
    <title>P3M UNIM - Admin Dashboard</title>
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
    <div class="flex h-screen overflow-hidden">
        <?php include __DIR__ . "/../layouts/sidebarAdmin.php" ?>
        <main class="flex-1 flex flex-col overflow-hidden pt-14 lg:pt-0">

            <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-background-light dark:bg-background-dark custom-scrollbar">
                <div class="mb-8">
                    <h2 class="text-xl md:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Ringkasan Statistik P3M</h2>
                    <p class="text-slate-500 mt-2 font-medium">Selamat datang kembali di pusat kendali P3M UNIM. Pantau perkembangan riset hari ini.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-10">
                    <div class="bg-white dark:bg-background-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-2xl">science</span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider text-xs">Total Penelitian</p>
                        <h3 class="text-3xl font-black mt-1"><?= $countPenelitian ?></h3>
                    </div>
                    <div class="bg-white dark:bg-background-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-2xl">volunteer_activism</span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider text-xs">Total Pengabdian</p>
                        <h3 class="text-3xl font-black mt-1"><?= $countPengabdian ?></h3>
                    </div>
                    <div class="bg-white dark:bg-background-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-2xl">person_celebrate</span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider text-xs">Pengabdian Mandiri</p>
                        <h3 class="text-3xl font-black mt-1"><?= $countPengabdianMandiri ?></h3>
                    </div>
                    <div class="bg-white dark:bg-background-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-2xl">groups</span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider text-xs">Total KKN</p>
                        <h3 class="text-3xl font-black mt-1"><?= $countKKN ?></h3>
                    </div>
                    <div class="bg-white dark:bg-background-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-2xl">description</span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider text-xs">Total Dokumen</p>
                        <h3 class="text-3xl font-black mt-1"><?= $totalFiles ?></h3>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-8">
                    <div class="bg-white dark:bg-background-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                            <h4 class="font-bold text-lg text-slate-900 dark:text-white">Aktivitas Terbaru</h4>

                        </div>
                        <div class="flex-1 overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 dark:bg-slate-800/50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Judul Kegiatan</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Kategori</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Status</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <?php if (empty($recentArticles)): ?>
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                                Belum ada aktivitas terbaru.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recentArticles as $article): ?>
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors">
                                                <td class="px-6 py-4">
                                                    <p class="font-semibold text-slate-800 dark:text-slate-200"><?= htmlspecialchars($article['title']) ?></p>
                                                    <p class="text-xs text-slate-400">Penulis: <?= htmlspecialchars($article['author'] ?? 'Admin') ?></p>
                                                </td>
                                                <td class="px-6 py-4 text-sm">
                                                    <span class="capitalize"><?= htmlspecialchars($article['category']) ?></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold uppercase">Published</span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-slate-500">
                                                    <?= date('d M Y', strtotime($article['published_date'])) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>

</html>