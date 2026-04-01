<!DOCTYPE html>

<html lang="en">

<head>

    <title>P3M UNIM - Research, Publication &amp; Community Service</title>
    <?php include __DIR__ . '/../helpers/HeadConfig.php'; ?>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 transition-colors duration-300">
    <?php include __DIR__ . '/layouts/navbar.php'; ?>
    <!-- Hero Section -->
    <section class="relative h-[600px] flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-slate-900">
            <img alt="Kampus Universitas Islam Majapahit" class="w-full h-full object-cover opacity-60" data-alt="Kampus Universitas Islam Majapahit" src="/public/images/fotounim.webp" />
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/60 to-transparent"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-2xl">
                <span class="inline-block bg-primary/20 text-primary px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-primary/30">Memajukan Keunggulan Penelitian</span>
                <h2 class="text-5xl md:text-6xl font-black text-white leading-tight mb-6">Memajukan Pengetahuan, <span class="text-primary">Mengabdi pada Masyarakat.</span></h2>
                <p class="text-lg text-slate-300 mb-10 leading-relaxed">Pusat Penelitian, Publikasi dan Pengabdian kepada Masyarakat (P3M) UNIM berdedikasi untuk mendorong inovasi dan dampak sosial melalui keunggulan akademik.</p>
                <div class="flex flex-wrap gap-4">
                    <a class="bg-primary text-background-dark px-8 py-4 rounded-xl font-bold flex items-center gap-2 hover:shadow-lg hover:shadow-primary/20 transition-all" href="https://ejurnal.unim.ac.id/" target="_blank"> Lihat Publikasi <span class="material-symbols-outlined">arrow_forward</span></a>
                </div>
            </div>
        </div>
    </section>
    <!-- Statistics Section -->
    <section class="relative -mt-16 z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform">
                <div class="bg-primary/10 text-primary p-4 rounded-xl mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-4xl">article</span>
                </div>
                <h3 class="text-4xl font-black mb-1"><?= $totalArticles ?></h3>
                <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider text-sm">Total Artikel Publikasi</p>
            </div>
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform">
                <div class="bg-primary/10 text-primary p-4 rounded-xl mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-4xl">description</span>
                </div>
                <h3 class="text-4xl font-black mb-1"><?= $totalFiles ?></h3>
                <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider text-sm">Total Dokumen Terupload</p>
            </div>
        </div>
    </section>
    <!-- Quick Access Section -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-black mb-2">Akses Cepat</h2>
                <p class="text-slate-500 dark:text-slate-400">Tautan langsung ke portal penelitian dan mahasiswa kami</p>
            </div>
            <div class="h-1 flex-1 mx-8 bg-slate-100 dark:bg-slate-800 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a class="group relative overflow-hidden bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl transition-all" href="https://ejurnal.unim.ac.id/" target="_blank">
                <div class="relative z-10 flex items-start gap-5">
                    <div class="bg-primary text-background-dark p-3 rounded-lg shadow-lg group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">auto_stories</span>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold mb-1">E-Jurnal</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Akses koleksi jurnal ilmiah dan publikasi riset UNIM.</p>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 text-slate-100 dark:text-slate-700/50 group-hover:text-primary/10 transition-colors">
                    <span class="material-symbols-outlined text-[120px]">library_books</span>
                </div>
            </a>
            <a class="group relative overflow-hidden bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl transition-all" href="/panduan-layanan-hki">
                <div class="relative z-10 flex items-start gap-5">
                    <div class="bg-primary text-background-dark p-3 rounded-lg shadow-lg group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">article</span>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold mb-1">Layanan HKI</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Informasi pendaftaran Hak Kekayaan Intelektual.</p>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 text-slate-100 dark:text-slate-700/50 group-hover:text-primary/10 transition-colors">
                    <span class="material-symbols-outlined text-[120px]">gavel</span>
                </div>
            </a>
            <a class="group relative overflow-hidden bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl transition-all" href="/contact-us">
                <div class="relative z-10 flex items-start gap-5">
                    <div class="bg-primary text-background-dark p-3 rounded-lg shadow-lg group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">mail</span>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold mb-1">Hubungi Kami</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Pertanyaan atau bantuan teknis seputar layanan P3M.</p>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 text-slate-100 dark:text-slate-700/50 group-hover:text-primary/10 transition-colors">
                    <span class="material-symbols-outlined text-[120px]">contact_support</span>
                </div>
            </a>
        </div>
    </section>
    </div>
    </div>
    </section>

    <!-- Latest News Section (General) -->
    <?php if (!empty($latestNews)): ?>
        <section class="py-20 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Berita & Update Terbaru</h2>
                        <p class="text-slate-500 dark:text-slate-400">Tetap terinformasi tentang kegiatan P3M UNIM</p>
                    </div>
                    <a class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all" href="/hasil-pencarian">Lihat Semua Berita <span class="material-symbols-outlined">arrow_right_alt</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($latestNews as $news): ?>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-100 dark:border-slate-700">
                            <div class="relative h-56 overflow-hidden">
                                <img alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= htmlspecialchars($news['thumbnail'] ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBlD0AyUn8XpTkrZnlR9DCYdqedR7ZTI9lRmy0uA-zb517Q9Ys_IH5O56jnLQmY2_6yxq9xBb4KMcQN4B-JknkDw-6jF5kTZJayki9W2PtJPEfnV4kOVKLACyltBYtCdf9FbjIswNPywkhhj2qUcOujPPDcu60K-lIZx-Omzb-ZII_J3Ua-T3GBBuEzpTDwEQvMeOAyv7ApxOK4PsNes03lHpop8fTs356G_ljNFhMGZRdLCHEY-rFAVePFvWdbMGr73Onup1dFVmg') ?>" />
                                <div class="absolute top-4 left-4">
                                    <span class="bg-primary text-background-dark text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest"><?= htmlspecialchars($news['category'] ?? 'Berita') ?></span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span> <?= date('M d, Y', strtotime($news['published_date'])) ?>
                                </div>
                                <h3 class="text-xl font-bold mb-3 line-clamp-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($news['title']) ?></h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 line-clamp-3"><?= htmlspecialchars(substr(strip_tags($news['content']), 0, 150)) ?>...</p>
                                <a class="inline-flex items-center gap-2 text-sm font-bold border-b-2 border-primary/20 hover:border-primary transition-colors pb-1" href="/artikel/<?= urlencode($news['category']) ?>/<?= urlencode($news['slug']) ?>">Baca Selengkapnya</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- KKN Section -->
    <?php if (!empty($kknArticles)): ?>
        <section class="py-20 bg-white dark:bg-slate-800/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Informasi KKN</h2>
                        <p class="text-slate-500 dark:text-slate-400">Update terbaru mengenai Kuliah Kerja Nyata</p>
                    </div>
                    <a class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all" href="/informasi-kkn-unim">Lihat Semua KKN <span class="material-symbols-outlined">arrow_right_alt</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($kknArticles as $news): ?>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-100 dark:border-slate-700">
                            <div class="relative h-56 overflow-hidden">
                                <img alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= htmlspecialchars($news['thumbnail'] ?: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=800&auto=format&fit=crop') ?>" />
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span> <?= date('M d, Y', strtotime($news['published_date'])) ?>
                                </div>
                                <h3 class="text-xl font-bold mb-3 line-clamp-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($news['title']) ?></h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 line-clamp-3"><?= htmlspecialchars(substr(strip_tags($news['content']), 0, 150)) ?>...</p>
                                <a class="inline-flex items-center gap-2 text-sm font-bold border-b-2 border-primary/20 hover:border-primary transition-colors pb-1" href="/artikel/<?= urlencode($news['category']) ?>/<?= urlencode($news['slug']) ?>">Baca Selengkapnya</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Pengabdian Masyarakat Section -->
    <?php if (!empty($pengabdianArticles)): ?>
        <section class="py-20 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Pengabdian Masyarakat</h2>
                        <p class="text-slate-500 dark:text-slate-400">Kontribusi nyata UNIM untuk masyarakat</p>
                    </div>
                    <a class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all" href="/informasi-pengabdian-kepada-masyarakat">Lihat Semua Pengabdian <span class="material-symbols-outlined">arrow_right_alt</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($pengabdianArticles as $news): ?>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-100 dark:border-slate-700">
                            <div class="relative h-56 overflow-hidden">
                                <img alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= htmlspecialchars($news['thumbnail'] ?: 'https://images.unsplash.com/photo-1526628953301-3e589a6a8b74?q=80&w=800&auto=format&fit=crop') ?>" />
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span> <?= date('M d, Y', strtotime($news['published_date'])) ?>
                                </div>
                                <h3 class="text-xl font-bold mb-3 line-clamp-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($news['title']) ?></h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 line-clamp-3"><?= htmlspecialchars(substr(strip_tags($news['content']), 0, 150)) ?>...</p>
                                <a class="inline-flex items-center gap-2 text-sm font-bold border-b-2 border-primary/20 hover:border-primary transition-colors pb-1" href="/artikel/<?= urlencode($news['category']) ?>/<?= urlencode($news['slug']) ?>">Baca Selengkapnya</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Pengabdian Mandiri Section -->
    <?php if (!empty($pengabdianMandiriArticles)): ?>
        <section class="py-20 bg-white dark:bg-slate-800/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Pengabdian Mandiri</h2>
                        <p class="text-slate-500 dark:text-slate-400">Program inisiatif pengabdian dosen</p>
                    </div>
                    <a class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all" href="/informasi-pengabdian-kepada-masyarakat-mandiri">Lihat Semua Mandiri <span class="material-symbols-outlined">arrow_right_alt</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($pengabdianMandiriArticles as $news): ?>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-100 dark:border-slate-700">
                            <div class="relative h-56 overflow-hidden">
                                <img alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= htmlspecialchars($news['thumbnail'] ?: 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=800&auto=format&fit=crop') ?>" />
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span> <?= date('M d, Y', strtotime($news['published_date'])) ?>
                                </div>
                                <h3 class="text-xl font-bold mb-3 line-clamp-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($news['title']) ?></h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 line-clamp-3"><?= htmlspecialchars(substr(strip_tags($news['content']), 0, 150)) ?>...</p>
                                <a class="inline-flex items-center gap-2 text-sm font-bold border-b-2 border-primary/20 hover:border-primary transition-colors pb-1" href="/artikel/<?= urlencode($news['category']) ?>/<?= urlencode($news['slug']) ?>">Baca Selengkapnya</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Penelitian Section -->
    <?php if (!empty($penelitianArticles)): ?>
        <section class="py-20 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Informasi Penelitian</h2>
                        <p class="text-slate-500 dark:text-slate-400">Hasil riset dan inovasi terbaru</p>
                    </div>
                    <a class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all" href="/informasi_penelitian">Lihat Semua Penelitian <span class="material-symbols-outlined">arrow_right_alt</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($penelitianArticles as $news): ?>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-100 dark:border-slate-700">
                            <div class="relative h-56 overflow-hidden">
                                <img alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= htmlspecialchars($news['thumbnail'] ?: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=800&auto=format&fit=crop') ?>" />
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span> <?= date('M d, Y', strtotime($news['published_date'])) ?>
                                </div>
                                <h3 class="text-xl font-bold mb-3 line-clamp-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($news['title']) ?></h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 line-clamp-3"><?= htmlspecialchars(substr(strip_tags($news['content']), 0, 150)) ?>...</p>
                                <a class="inline-flex items-center gap-2 text-sm font-bold border-b-2 border-primary/20 hover:border-primary transition-colors pb-1" href="/artikel/<?= urlencode($news['category']) ?>/<?= urlencode($news['slug']) ?>">Baca Selengkapnya</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php include 'layouts/footer.php'; ?>
</body>

</html>