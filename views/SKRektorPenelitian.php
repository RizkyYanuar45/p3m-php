<!DOCTYPE html>

<html class="light" lang="id">

<head>

    <title>SK Rektor Penelitian - Repositori Publik</title>
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
                <h1 class="text-[#0d1b16] text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4">SK Rektor Penelitian</h1>
                <p class="text-[#4c9a79] text-lg max-w-2xl leading-relaxed">
                    Pusat unduhan resmi untuk dokumen institusi, formulir penelitian, dan template pengabdian masyarakat Universitas Islam Majapahit.
                </p>
            </div>


            <!-- Vertical Stepper List -->
            <div class="space-y-0">
                <?php if (empty($files)): ?>
                    <div class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-2xl border-2 border-dashed border-slate-100 dark:border-slate-800">
                        <span class="material-symbols-outlined text-6xl text-[#cfe7dd] mb-4">search_off</span>
                        <h3 class="text-xl font-bold text-[#0d1b16]">Dokumen tidak ditemukan</h3>
                        <p class="text-[#4c9a79] mt-2">Belum ada SK Rektor Penelitian yang diunggah.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($files as $index => $file): ?>
                        <!-- Stepper Item -->
                        <div class="stepper-item relative flex gap-6 <?= $index === count($files) - 1 ? '' : 'pb-10' ?>">
                            <div class="stepper-line flex flex-col items-center flex-none">
                                <div class="z-10 flex size-10 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-primary/30">
                                    <span class="material-symbols-outlined">
                                        <?php
                                        $ext = strtolower(pathinfo($file['file_name'], PATHINFO_EXTENSION));
                                        if (in_array($ext, ['pdf'])) echo 'picture_as_pdf';
                                        elseif (in_array($ext, ['doc', 'docx'])) echo 'description';
                                        else echo 'draft';
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1 bg-white dark:bg-slate-900 p-6 rounded-xl border border-primary/5 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-[#0d1b16] dark:text-slate-100"><?= htmlspecialchars($file['file_name']) ?></h3>
                                        <p class="text-sm text-[#4c9a79] mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                                            Diunggah: <?= date('d F Y', strtotime($file['createdAt'])) ?>
                                        </p>
                                        <?php if ($file['file_description']): ?>
                                            <p class="text-xs text-slate-500 mt-2 line-clamp-2"><?= htmlspecialchars($file['file_description']) ?></p>
                                        <?php endif; ?>
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
                    <p class="text-sm text-[#4c9a79]">
                        Menampilkan <?= count($files) ?> dari <?= $totalFiles ?> dokumen tersedia
                    </p>
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
                                    <span class="px-2 text-gray-400 font-bold">...</span>
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