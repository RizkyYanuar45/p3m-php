<!DOCTYPE html>

<html lang="id">

<head>
    <title>Luaran P3M UNIM - Universitas Islam Majapahit</title>
    <?php include __DIR__ . "/../helpers/HeadConfig.php" ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 ratio */
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0d1b16] font-display">
    <!-- Top Navigation Bar -->
    <?php include __DIR__ . "/layouts/navbar.php" ?>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Hero Section -->
        <div class="mb-12">
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a class="hover:text-primary" href="#">Beranda</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-primary font-medium">Video Luaran Kegiatan</span>
            </nav>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-4xl md:text-5xl font-black text-[#0d1b16] mb-4 leading-tight">
                        Luaran Video <span class="text-primary">P3M UNIM</span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Dokumentasi visual dari hasil inovasi, penelitian unggulan, dan program pengabdian masyarakat oleh sivitas akademika Universitas Islam Majapahit.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="px-4 py-2 bg-secondary/10 text-secondary border border-secondary/20 rounded-full text-xs font-bold uppercase tracking-wider">Arsip Digital</span>
                    <span class="px-4 py-2 bg-primary/10 text-primary border border-primary/20 rounded-full text-xs font-bold uppercase tracking-wider">Publik</span>
                </div>
            </div>
        </div>
        <!-- Filter & Search Section -->
        <!-- <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-10 sticky top-24 z-40">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1 w-full relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input class="w-full pl-12 pr-4 py-3 bg-background-light border-none rounded-lg focus:ring-2 focus:ring-primary/50 text-gray-700 placeholder:text-gray-400" placeholder="Cari judul video, topik, atau nama peneliti..." type="text" />
                </div>
                <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                    <button class="whitespace-nowrap px-6 py-2.5 bg-primary text-white rounded-lg font-bold text-sm shadow-md shadow-primary/20">Semua</button>
                    <button class="whitespace-nowrap px-6 py-2.5 bg-background-light text-gray-600 hover:bg-gray-100 rounded-lg font-semibold text-sm transition-colors">Penelitian</button>
                    <button class="whitespace-nowrap px-6 py-2.5 bg-background-light text-gray-600 hover:bg-gray-100 rounded-lg font-semibold text-sm transition-colors">Pengabdian</button>
                </div>
            </div>
        </div> -->
        <!-- Video Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (empty($videos)): ?>
                <div class="col-span-full py-20 bg-white dark:bg-slate-900 rounded-2xl border-2 border-dashed border-slate-100 dark:border-slate-800 text-center">
                    <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">video_library</span>
                    <h3 class="text-xl font-bold text-slate-400">Belum ada video luaran</h3>
                    <p class="text-slate-400 text-sm mt-2">Daftar video kegiatan akan segera diperbarui oleh tim P3M.</p>
                </div>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                    <?php
                    // Helper to convert YouTube URL to Embed format
                    $embedUrl = $video['link'];
                    if (strpos($embedUrl, 'youtube.com/watch?v=') !== false) {
                        $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                    } elseif (strpos($embedUrl, 'youtu.be/') !== false) {
                        $embedUrl = str_replace('youtu.be/', 'youtube.com/embed/', $embedUrl);
                    }
                    ?>
                    <div class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-slate-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="video-container bg-black">
                            <iframe allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" src="<?= htmlspecialchars($embedUrl) ?>" title="<?= htmlspecialchars($video['title']) ?>"></iframe>
                        </div>
                        <div class="p-5 border-t-4 border-primary/10 group-hover:border-primary transition-colors">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[10px] font-bold px-2 py-0.5 bg-primary/10 text-primary rounded-full uppercase">Visual Luaran</span>
                                <span class="text-[10px] font-medium text-gray-400"><?= date('d M Y', strtotime($video['published_date'] ?? $video['createdAt'])) ?></span>
                            </div>
                            <h3 class="text-lg font-bold text-[#0d1b16] dark:text-slate-100 leading-snug group-hover:text-primary transition-colors">
                                <?= htmlspecialchars($video['title']) ?>
                            </h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="mt-16 flex justify-center items-center gap-2">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 dark:border-slate-800 text-gray-400 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == 1 || $i == $totalPages || ($i >= $page - 2 && $i <= $page + 2)): ?>
                        <a href="?page=<?= $i ?>" class="w-10 h-10 flex items-center justify-center rounded-lg <?= $i == $page ? 'bg-primary text-white font-bold shadow-md shadow-primary/20' : 'border border-gray-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-gray-600 dark:text-gray-400 font-semibold hover:border-primary hover:text-primary transition-colors' ?>">
                            <?= $i ?>
                        </a>
                    <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
                        <span class="px-2 text-gray-400 font-bold">...</span>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 dark:border-slate-800 text-gray-400 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
    <!-- Footer Section -->
    <?php include __DIR__ . "/layouts/footer.php" ?>
</body>

</html>