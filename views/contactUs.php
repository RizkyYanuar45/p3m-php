<!DOCTYPE html>

<html lang="id">

<head>

    <title>Kontak Kami - P3M UNIM</title>

    <?php include __DIR__ . '/../helpers/HeadConfig.php'; ?>
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
    <!-- Navigation -->
    <?php include __DIR__ . '/layouts/navbar.php'; ?>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 tracking-tight">
                Lokasi &amp; Kontak Kami
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
                Kami siap membantu Anda. Kunjungi lokasi kami atau hubungi kami melalui kontak di bawah ini untuk informasi lebih lanjut mengenai penelitian dan pengabdian masyarakat.
            </p>
        </div>
        <!-- Contact Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16 lg:grid-cols-2">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">location_on</span>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-2">Alamat</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Tambak Rejo, Gayaman KM 7, Kec. Mojoanyar, Kabupaten Mojokerto, Jawa Timur 61364
                </p>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">call</span>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-2">Telepon</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    (031) 123-4567<br />
                    (031) 123-4568 (Fax)
                </p>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-2">Email</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    kontak.kami@example.com<br />
                    p3m@unim.ac.id
                </p>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-2">Jam Kerja</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Senin - Jumat<br />
                    08:00 - 16:00 WIB
                </p>
            </div>
        </div>
        <!-- Interactive Section: Map & Form -->
        <div class="grid grid-cols-1 gap-12 items-start max-w-4xl mx-auto w-full">
            <!-- Contact Form -->

            <!-- Map Section -->
            <div class="h-full min-h-[500px] flex flex-col gap-4">
                <div class="flex-1 bg-slate-200 dark:bg-slate-800 rounded-2xl overflow-hidden relative border border-slate-200 dark:border-slate-700"><iframe allowfullscreen="" height="100%" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d988.9364560485635!2d112.463054!3d-7.493291000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e780d0a536939db%3A0xc5f96b1753d7b9e1!2sGedung%20Al%20Hambra%20FKIP%20UNIM!5e0!3m2!1sid!2sid!4v1771517225095!5m2!1sid!2sid" style="border:0;" width="100%"></iframe>
                    <div class="absolute bottom-4 left-4 right-4 bg-white/95 dark:bg-slate-900/95 p-4 rounded-xl shadow-lg border border-slate-200 dark:border-slate-800 backdrop-blur-sm flex items-center gap-4">
                        <div class="bg-primary p-3 rounded-lg text-white">
                            <span class="material-symbols-outlined">directions</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-primary uppercase tracking-wider">Lokasi Kami</p>
                            <p class="text-sm font-medium text-slate-900 dark:text-white">Gedung P3M UNIM, Mojokerto</p>
                        </div>
                        <button class="ml-auto bg-slate-100 dark:bg-slate-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                            Buka Map
                        </button>
                    </div>
                </div>
                <div class="p-4 bg-primary/5 rounded-xl border border-primary/20 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <p class="text-xs text-slate-700 dark:text-slate-300 italic leading-snug">
                        Terletak strategis di jalur utama Gayaman, memudahkan akses bagi mitra penelitian dan masyarakat umum.
                    </p>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/layouts/footer.php'; ?>
</body>

</html>