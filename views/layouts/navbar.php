<!-- Navigation Bar -->
<header class="sticky top-0 z-50 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col py-4 gap-4">
            <!-- Row 1: Logo & Mobile Menu -->
            <div class="flex justify-between lg:justify-center items-center">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img src="/public/images/logo.ico" alt="Logo P3M" class="h-12 w-auto">
                    <div>
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-slate-900 dark:text-white">P3M</h1>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 dark:text-slate-400 font-semibold">Pusat Penelitian, Publikasi <span class=" block">dan Pengabdian kepada Masyarakat</span> </p>
                    </div>
                </div>

                <!-- Mobile Menu Button (Moved to Row 1) -->
                <button id="mobile-menu-button" class="lg:hidden text-slate-900 dark:text-white">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>
            </div>

            <!-- Row 2: Navigation Links (Desktop only Row) -->
            <div class="hidden lg:flex justify-between items-center border-t border-slate-100 dark:border-slate-700 pt-3">
                <nav class="flex items-center gap-6 mx-auto">
                    <a class="text-sm font-semibold hover:text-primary transition-colors" href="/">Beranda</a>

                    <!-- Profile Dropdown -->
                    <div class="relative nav-dropdown group">
                        <button class="flex items-center gap-1 text-sm font-semibold hover:text-primary transition-colors">Profil <span class="material-symbols-outlined text-sm">expand_more</span></button>
                        <div class="dropdown-menu hidden absolute top-full left-0 w-56 pt-2 z-50">
                            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 overflow-hidden">
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/struktur-organisasi">Struktur Organisasi</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/dokumen-p3m">Dokumen P3M</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/luaran-p3m">Luaran P3M</a>
                            </div>
                        </div>
                    </div>

                    <!-- Research Dropdown -->
                    <div class="relative nav-dropdown group">
                        <button class="flex items-center gap-1 text-sm font-semibold hover:text-primary transition-colors">Penelitian <span class="material-symbols-outlined text-sm">expand_more</span></button>
                        <div class="dropdown-menu hidden absolute top-full left-0 w-56 pt-2 z-50">
                            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 overflow-hidden">
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/panduan-penelitian-p3m">Panduan Penelitian</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/sk-rektor-penelitian">SK Rektor Penelitian</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/dokumen-penelitian">Dokumen Penelitian</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/informasi_penelitian">Informasi Penelitian</a>
                            </div>
                        </div>
                    </div>

                    <!-- Community Service Dropdown -->
                    <div class="relative nav-dropdown group">
                        <button class="flex items-center gap-1 text-sm font-semibold hover:text-primary transition-colors">Pengabdian <span class="material-symbols-outlined text-sm">expand_more</span></button>
                        <div class="dropdown-menu hidden absolute top-full left-0 w-56 pt-2 z-50">
                            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 overflow-hidden">
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/informasi-pengabdian-kepada-masyarakat-mandiri">Informasi Pengabdian Kepada Masyarakat Mandiri</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/pengabdian-kepada-masyarakat-mandiri">Pengabdian Kepada Masyarakat Mandiri</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/panduan-pengabdian-kepada-masyarakat">Panduan Pengabdian Kepada Masyarakat</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/informasi-pengabdian-kepada-masyarakat">Informasi Pengabdian Kepada Masyarakat</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/sk-pengabdian-kepada-masyarakat">SK Pengabdian Kepada Masyarakat</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/dokumen-pengabdian-kepada-masyarakat">Dokumen Pengabdian Kepada Masyarakat</a>
                            </div>
                        </div>
                    </div>

                    <!-- KKN Dropdown -->
                    <div class="relative nav-dropdown group">
                        <button class="flex items-center gap-1 text-sm font-semibold hover:text-primary transition-colors">KKN <span class="material-symbols-outlined text-sm">expand_more</span></button>
                        <div class="dropdown-menu hidden absolute top-full left-0 w-56 pt-2 z-50">
                            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 overflow-hidden">
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/informasi-kkn-unim">Informasi KKN UNIM</a>

                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/buku-panduan-kkn-tematik">Buku Panduan KKN Tematik</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/buku-panduan-kkn-bem">Buku Panduan KKN BEM</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="/buku-panduan-kkn-pmm">Buku Panduan KKN PMM</a>
                            </div>
                        </div>
                    </div>

                    <!-- Kuisioner Dropdown -->
                    <div class="relative nav-dropdown group">
                        <button class="flex items-center gap-1 text-sm font-semibold hover:text-primary transition-colors">Kuisioner / Komplain<span class="material-symbols-outlined text-sm">expand_more</span></button>
                        <div class="dropdown-menu hidden absolute top-full left-0 w-64 pt-2 z-50">
                            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 overflow-hidden">
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="https://docs.google.com/forms/d/17VUsm6-JGP6wSN5XDaGDUfMetjYCGxUTnRMituPdcxI/viewform?edit_requested=true">Survey Kepuasan Layanan P3M</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="https://forms.gle/F4ej5fJJF7vzX6CFA">Survey Kepuasan Mitra P3M</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="https://forms.gle/Cn65r9inDa3RNEVr5">Survey Kepuasan Mitra Penelitian</a>
                                <a class="block px-4 py-2.5 text-sm hover:bg-primary/10 rounded-lg" href="https://forms.gle/bihQBd1qJmd5HEVY8">Survey Kepuasan Mitra KKN</a>
                            </div>
                        </div>
                    </div>

                    <a class="text-sm font-semibold hover:text-primary transition-colors" href="https://ejurnal.unim.ac.id/">E-Jurnal</a>
                    <a class="text-sm font-semibold hover:text-primary transition-colors" href="/panduan-layanan-hki">Layanan HKI</a>
                    <a class="text-sm font-semibold hover:text-primary transition-colors" href="/contact-us">Hubungi Kami</a>

                </nav>
            </div>

            <!-- Mobile Menu Drawer (Hidden by default) -->
            <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 dark:border-slate-700 py-4">
                <div class="flex flex-col gap-2">
                    <a class="px-4 py-2 text-sm font-semibold hover:bg-primary/10 rounded-lg transition-colors border-l-4 border-transparent hover:border-primary" href="/">Beranda</a>

                    <!-- Mobile Profile Group -->
                    <div class="flex flex-col">
                        <button onclick="toggleMobileSubmenu('mobile-profil')" class="flex justify-between items-center w-full px-4 py-3 text-sm font-bold tracking-wider text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <span>PROFIL</span>
                            <span class="material-symbols-outlined text-xl transition-transform" id="icon-mobile-profil">expand_more</span>
                        </button>
                        <div id="mobile-profil" class="hidden flex-col pl-4 border-l-2 border-slate-100 dark:border-slate-800 ml-6 mt-1 space-y-1">
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/struktur-organisasi">Struktur Organisasi</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/dokumen-p3m">Dokumen P3M</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/luaran-p3m">Luaran P3M</a>
                        </div>
                    </div>

                    <!-- Mobile Research Group -->
                    <div class="flex flex-col">
                        <button onclick="toggleMobileSubmenu('mobile-penelitian')" class="flex justify-between items-center w-full px-4 py-3 text-sm font-bold tracking-wider text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <span>PENELITIAN</span>
                            <span class="material-symbols-outlined text-xl transition-transform" id="icon-mobile-penelitian">expand_more</span>
                        </button>
                        <div id="mobile-penelitian" class="hidden flex-col pl-4 border-l-2 border-slate-100 dark:border-slate-800 ml-6 mt-1 space-y-1">
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/panduan-penelitian-p3m">Panduan Penelitian</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/sk-rektor-penelitian">SK Rektor Penelitian</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/dokumen-penelitian">Dokumen Penelitian</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/informasi_penelitian">Informasi Penelitian</a>
                        </div>
                    </div>

                    <!-- Mobile Community Service Group -->
                    <div class="flex flex-col">
                        <button onclick="toggleMobileSubmenu('mobile-pengabdian')" class="flex justify-between items-center w-full px-4 py-3 text-sm font-bold tracking-wider text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <span>PENGABDIAN</span>
                            <span class="material-symbols-outlined text-xl transition-transform" id="icon-mobile-pengabdian">expand_more</span>
                        </button>
                        <div id="mobile-pengabdian" class="hidden flex-col pl-4 border-l-2 border-slate-100 dark:border-slate-800 ml-6 mt-1 space-y-1">
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/informasi-pengabdian-kepada-masyarakat-mandiri">Info PkM Mandiri</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/pengabdian-kepada-masyarakat-mandiri">PkM Mandiri</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/panduan-pengabdian-kepada-masyarakat">Panduan PkM</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/informasi-pengabdian-kepada-masyarakat">Informasi PkM</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/sk-pengabdian-kepada-masyarakat">SK PkM</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/dokumen-pengabdian-kepada-masyarakat">Dokumen PkM</a>
                        </div>
                    </div>

                    <!-- Mobile KKN Group -->
                    <div class="flex flex-col">
                        <button onclick="toggleMobileSubmenu('mobile-kkn')" class="flex justify-between items-center w-full px-4 py-3 text-sm font-bold tracking-wider text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <span>KKN</span>
                            <span class="material-symbols-outlined text-xl transition-transform" id="icon-mobile-kkn">expand_more</span>
                        </button>
                        <div id="mobile-kkn" class="hidden flex-col pl-4 border-l-2 border-slate-100 dark:border-slate-800 ml-6 mt-1 space-y-1">
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/informasi-kkn-unim">Informasi KKN UNIM</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/buku-panduan-kkn-tematik">Panduan KKN Tematik</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/buku-panduan-kkn-bem">Panduan KKN BEM</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="/buku-panduan-kkn-pmm">Panduan KKN PMM</a>
                        </div>
                    </div>

                    <!-- Mobile Kuisioner Group -->
                    <div class="flex flex-col">
                        <button onclick="toggleMobileSubmenu('mobile-kuisioner')" class="flex justify-between items-center w-full px-4 py-3 text-sm font-bold tracking-wider text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <span>KUISIONER / KOMPLAIN</span>
                            <span class="material-symbols-outlined text-xl transition-transform" id="icon-mobile-kuisioner">expand_more</span>
                        </button>
                        <div id="mobile-kuisioner" class="hidden flex-col pl-4 border-l-2 border-slate-100 dark:border-slate-800 ml-6 mt-1 space-y-1">
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="https://docs.google.com/forms/d/17VUsm6-JGP6wSN5XDaGDUfMetjYCGxUTnRMituPdcxI/viewform?edit_requested=true">Survey Kepuasan Layanan P3M</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="https://forms.gle/F4ej5fJJF7vzX6CFA">Survey Kepuasan Mitra P3M</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="https://forms.gle/Cn65r9inDa3RNEVr5">Survey Kepuasan Mitra Penelitian</a>
                            <a class="px-4 py-2 text-sm hover:text-primary transition-colors text-slate-600 dark:text-slate-400" href="https://forms.gle/bihQBd1qJmd5HEVY8">Survey Kepuasan Mitra KKN</a>
                        </div>
                    </div>

                    <a class="px-4 py-2 text-sm font-semibold hover:bg-primary/10 rounded-lg" href="https://ejurnal.unim.ac.id/">E-Jurnal</a>
                    <a class="px-4 py-2 text-sm font-semibold hover:bg-primary/10 rounded-lg" href="/panduan-layanan-hki">Layanan HKI</a>
                    <a class="px-4 py-2 text-sm font-semibold hover:bg-primary/10 rounded-lg" href="/contact-us">Hubungi Kami</a>
                </div>
            </div>

            <!-- Row 3: Search Bar -->
            <div class="flex justify-center border-t border-slate-100 dark:border-slate-700 pt-3">
                <form action="/hasil-pencarian" method="GET" class="relative w-full max-w-2xl">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400">search</span>
                    </div>
                    <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" class="block w-full p-3 pl-10 text-sm text-slate-900 border border-slate-300 rounded-full bg-slate-50 focus:ring-primary focus:border-primary dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary shadow-sm" placeholder="Cari publikasi, penelitian, atau informasi pengabdian..." required>
                    <button type="submit" class="absolute right-2.5 bottom-2 top-2 bg-primary hover:bg-primary/90 text-white font-medium rounded-full text-sm px-4 py-1">Cari</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for mobile menu -->
    <script>
        // Main Hamburger Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const icon = this.querySelector('.material-symbols-outlined');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.textContent = 'close';
            } else {
                menu.classList.add('hidden');
                icon.textContent = 'menu';
            }
        });

        // Submenu Dropdown Toggle logic
        function toggleMobileSubmenu(id) {
            const submenu = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                submenu.classList.add('flex');
                if (icon) icon.style.transform = "rotate(180deg)";
            } else {
                submenu.classList.add('hidden');
                submenu.classList.remove('flex');
                if (icon) icon.style.transform = "rotate(0deg)";
            }
        }
    </script>
</header>