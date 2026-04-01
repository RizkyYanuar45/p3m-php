<!DOCTYPE html>

<html class="light" lang="id">

<head>

    <title>SK Pengabdian Kepada Masyarakat - Repositori Publik</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <?php include __DIR__ . "/../helpers/HeadConfig.php" ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .stepper-line::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: 0;
            width: 2px;
            background-color: #cfe7dd;
        }

        .stepper-item:last-child .stepper-line::before {
            display: none;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#0d1b16]">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
        <!-- Navigation Header -->
        <?php include __DIR__ . "/layouts/navbar.php" ?>
        <main class="flex-1 max-w-5xl mx-auto w-full px-6 py-8 md:py-12">
            <!-- Hero / Title Section -->
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-[#0d1b16] text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4">SK Pengabdian Kepada Masyarakat</h1>
                <p class="text-[#4c9a79] text-lg max-w-2xl leading-relaxed">
                    Pusat unduhan resmi untuk dokumen institusi, formulir penelitian, dan template pengabdian masyarakat Universitas Islam Majapahit.
                </p>
            </div>


            <!-- Vertical Stepper List -->
            <div class="space-y-0">
                <?php if (empty($files)): ?>
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <span class="material-symbols-outlined text-6xl text-[#cfe7dd] mb-4">search_off</span>
                        <h3 class="text-xl font-bold text-[#0d1b16]">Belum ada SK Pengabdian tersedia</h3>
                        <p class="text-[#4c9a79] mt-2">Dokumen SK Rektor pengabdian masyarakat akan segera diperbarui oleh tim P3M.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($files as $index => $file): ?>
                        <?php 
                        $icon = 'description';
                        if (stripos($file['file_name'], 'SK') !== false) $icon = 'verified';
                        if (stripos($file['file_name'], 'Rektor') !== false) $icon = 'account_balance';
                        ?>
                        <div class="stepper-item relative flex gap-6 pb-10">
                            <div class="stepper-line flex flex-col items-center flex-none">
                                <div class="z-10 flex size-10 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-primary/30">
                                    <span class="material-symbols-outlined"><?= $icon ?></span>
                                </div>
                            </div>
                            <div class="flex-1 bg-white p-6 rounded-xl border border-primary/5 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-[#0d1b16]"><?= htmlspecialchars($file['file_name']) ?></h3>
                                        <p class="text-sm text-[#4c9a79] mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                                            Diunggah: <?= date('d F Y', strtotime($file['createdAt'])) ?>
                                        </p>
                                    </div>
                                    <a class="flex items-center justify-center gap-2 bg-secondary text-primary px-6 py-3 rounded-lg font-bold hover:bg-secondary/90 transition-all shadow-lg shadow-secondary/20" href="<?= htmlspecialchars($file['file_url']) ?>" target="_blank">
                                        <span class="material-symbols-outlined">download</span>
                                        Unduh File
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Footer Pagination/Info -->
            <?php if ($totalPages > 0): ?>
                <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-6 border-t border-[#cfe7dd] pt-8">
                    <p class="text-sm text-[#4c9a79]">Menampilkan <?= count($files) ?> dari <?= $totalFiles ?> dokumen tersedia</p>
                    <?php if ($totalPages > 1): ?>
                        <div class="flex gap-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>" class="size-10 flex items-center justify-center rounded-lg border border-primary/20 text-[#4c9a79] hover:bg-primary/10 transition-colors">
                                    <span class="material-symbols-outlined">chevron_left</span>
                                </a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php if ($i == 1 || $i == $totalPages || ($i >= $page - 2 && $i <= $page + 2)): ?>
                                    <a href="?page=<?= $i ?>" class="size-10 flex items-center justify-center rounded-lg <?= $i == $page ? 'bg-primary text-white font-bold' : 'border border-primary/20 text-[#4c9a79] hover:bg-primary/10 transition-colors' ?>">
                                        <?= $i ?>
                                    </a>
                                <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
                                    <span class="px-2 text-[#4c9a79]">...</span>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?= $page + 1 ?>" class="size-10 flex items-center justify-center rounded-lg border border-primary/20 text-[#4c9a79] hover:bg-primary/10 transition-colors">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
        <!-- Footer -->
        <?php include __DIR__ . "/layouts/footer.php" ?>
    </div>
</body>

</html>