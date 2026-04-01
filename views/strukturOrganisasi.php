<!DOCTYPE html>

<head>
    <title>Struktur Organisasi P3M - Universitas Islam Majapahit</title>
    <?php include __DIR__ . '/../helpers/HeadConfig.php'; ?>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .org-line {
            position: relative;
        }

        .org-line::after {
            content: '';
            position: absolute;
            background: #e2e8f0;
            z-index: -1;
        }

        .org-line-v::after {
            width: 2px;
            height: 100%;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
        }

        .org-line-h::after {
            height: 2px;
            width: 100%;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-neutral-text font-display">
    <!-- Top Navigation Bar -->
    <?php include 'layouts/navbar.php'; ?>
    <!-- Main Content Layout -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col">
            <!-- Sidebar Navigation -->

            <!-- Page Content -->
            <div class="flex-1">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-neutral-sub mb-4 font-medium">
                    <span>Profil</span>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-neutral-text">Struktur Organisasi</span>
                </div>
                <div class="mb-10">
                    <h2 class="text-4xl font-black text-neutral-text tracking-tight mb-2">Struktur Organisasi</h2>
                    <p class="text-neutral-sub text-lg leading-relaxed">Susunan kepengurusan Lembaga Penelitian dan Pengabdian Masyarakat Universitas Islam Majapahit.</p>
                </div>
                <!-- Organization Chart Visual -->
                <section class="mb-20">
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                        <?php if ($struktur && $struktur['image']): ?>
                            <img alt="<?= htmlspecialchars($struktur['alt'] ?: 'Struktur Organisasi P3M UNIM') ?>" class="w-full h-auto rounded-2xl" src="<?= htmlspecialchars($struktur['image']) ?>" />
                        <?php else: ?>
                            <div class="py-20 flex flex-col items-center justify-center text-center">
                                <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">image</span>
                                <h3 class="text-xl font-bold text-slate-400">Gambar Struktur Belum Tersedia</h3>
                                <p class="text-slate-400 text-sm mt-2">Silakan hubungi admin untuk memperbarui informasi ini.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>
</body>

</html>